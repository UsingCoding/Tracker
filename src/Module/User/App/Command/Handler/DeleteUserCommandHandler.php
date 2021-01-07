<?php

namespace App\Module\User\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Context\LoggedUserIdProviderInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\User\App\Command\DeleteUserCommand;
use App\Module\User\App\Exception\UserCantDeleteHimSelfException;
use App\Module\User\Domain\Service\UserService;

class DeleteUserCommandHandler implements AppCommandHandlerInterface
{
    private SynchronizationInterface $synchronization;
    private UserService $userService;
    private LoggedUserIdProviderInterface $loggedUserIdProvider;

    public function __construct(SynchronizationInterface $synchronization, UserService $userService, LoggedUserIdProviderInterface $loggedUserIdProvider)
    {
        $this->synchronization = $synchronization;
        $this->userService = $userService;
        $this->loggedUserIdProvider = $loggedUserIdProvider;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof DeleteUserCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => DeleteUserCommand::class]);
        }

        $payload = $command->getPayload();

        $userId = Arrays::get($payload, DeleteUserCommand::USER_ID);

        if ($userId === $this->loggedUserIdProvider->getUserId())
        {
            throw new UserCantDeleteHimSelfException('', ['user_id' => $userId]);
        }

        $this->synchronization->transaction(fn() =>
            $this->userService->deleteUser($userId)
        );
    }
}