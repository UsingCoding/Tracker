<?php

namespace App\Module\User\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\User\App\Command\EditUserCommand;
use App\Module\User\Domain\Service\UserDataSanitizer;
use App\Module\User\Domain\Service\UserService;

class EditUserCommandHandler implements AppCommandHandlerInterface
{
    private UserService $userService;
    private SynchronizationInterface $synchronization;

    public function __construct(UserService $userService, SynchronizationInterface $synchronization)
    {
        $this->userService = $userService;
        $this->synchronization = $synchronization;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof EditUserCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => EditUserCommand::class]);
        }

        $payload = $command->getPayload();

        $this->synchronization->transaction(fn() => $this->userService->editUser(
            Arrays::get($payload, EditUserCommand::USER_ID),
            UserDataSanitizer::sanitizeEmail(Arrays::get($payload, EditUserCommand::EMAIL)),
            Arrays::get($payload, EditUserCommand::USERNAME),
            Arrays::get($payload, EditUserCommand::PASSWORD),
            Arrays::get($payload, EditUserCommand::GRADE),
        ));
    }
}