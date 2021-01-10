<?php

namespace App\Module\User\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Event\AppEventDispatcherInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\User\App\Command\AddUserCommand;
use App\Module\User\App\Event\UserAddedEvent;
use App\Module\User\Domain\Model\User;
use App\Module\User\Domain\Service\UserService;

class AddUserCommandHandler implements AppCommandHandlerInterface
{
    private UserService $userService;
    private SynchronizationInterface $synchronization;
    private AppEventDispatcherInterface $eventDispatcher;

    public function __construct(UserService $userService, SynchronizationInterface $synchronization, AppEventDispatcherInterface $eventDispatcher)
    {
        $this->userService = $userService;
        $this->synchronization = $synchronization;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof AddUserCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => AddUserCommand::class]);
        }

        $payload = $command->getPayload();

        /** @var User $user */
        $user = $this->synchronization->transaction(fn() => $this->userService->addUser(
            Arrays::get($payload, AddUserCommand::EMAIL),
            Arrays::get($payload, AddUserCommand::USERNAME),
            Arrays::get($payload, AddUserCommand::PASSWORD),
            Arrays::get($payload, AddUserCommand::GRADE),
            Arrays::get($payload, AddUserCommand::AVATAR_URL)
        ));

        $this->eventDispatcher->dispatch(new UserAddedEvent($user->getId()));
    }
}