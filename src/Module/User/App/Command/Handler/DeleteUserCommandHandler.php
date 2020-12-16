<?php

namespace App\Module\User\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\User\App\Command\DeleteUserCommand;
use App\Module\User\Domain\Service\UserService;

class DeleteUserCommandHandler implements AppCommandHandlerInterface
{
    private SynchronizationInterface $synchronization;
    private UserService $userService;

    public function __construct(SynchronizationInterface $synchronization, UserService $userService)
    {
        $this->synchronization = $synchronization;
        $this->userService = $userService;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof DeleteUserCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => DeleteUserCommand::class]);
        }

        $payload = $command->getPayload();

        $this->synchronization->transaction(fn() =>
            $this->userService->deleteUser(Arrays::get($payload, DeleteUserCommand::USER_ID))
        );
    }
}