<?php

namespace App\Module\User\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Common\App\Event\AppEventHandlerInterface;
use App\Common\App\Event\AppEventInterface;
use App\Common\App\Event\AppEventSourceInterface;
use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Input\AddUserInput;
use App\Module\User\Api\Input\EditUserInput;
use App\Module\User\Api\Mapper\UserMapper;
use App\Module\User\Api\Output\UserListOutput;
use App\Module\User\Api\Output\UserOutput;
use App\Module\User\App\Command\AddUserCommand;
use App\Module\User\App\Command\DeleteUserCommand;
use App\Module\User\App\Command\EditUserCommand;
use App\Module\User\App\Event\UserAddedEvent;
use App\Module\User\App\Query\UserQueryServiceInterface;
use App\Module\User\App\Service\AuthenticationService;

class Api implements ApiInterface
{
    private AuthenticationService $authenticationService;
    private UserQueryServiceInterface $userQueryService;
    private AppCommandBusInterface $commandBus;
    private AppEventSourceInterface $eventSource;

    public function __construct(
        AuthenticationService $authenticationService,
        UserQueryServiceInterface $userQueryService,
        AppCommandBusInterface $userCommandBus,
        AppEventSourceInterface $eventSource
    )
    {
        $this->authenticationService = $authenticationService;
        $this->userQueryService = $userQueryService;
        $this->commandBus = $userCommandBus;
        $this->eventSource = $eventSource;
    }

    public function authorizeUserByEmail(string $usernameOrEmail, string $password): UserOutput
    {
        try
        {
            return UserMapper::getUserOutput($this->authenticationService->authenticate($usernameOrEmail, $password));
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function getUserById(int $userId): UserOutput
    {
        try
        {
            return UserMapper::getUserOutput($this->userQueryService->getUserById($userId));
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function getUserByUsername(string $userName): UserOutput
    {
        try
        {
            return UserMapper::getUserOutput($this->userQueryService->getUserByUsername($userName));
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function addUser(AddUserInput $input): int
    {
        $command = new AddUserCommand($input);

        return $this->publishCommandWithUserAddedEventHandler($command);
    }

    public function editUser(EditUserInput $input): void
    {
        $command = new EditUserCommand($input);

        $this->publish($command);
    }

    public function list(): UserListOutput
    {
        try
        {
            $list = $this->userQueryService->getList();

            return UserMapper::getUserListOutput($list);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function deleteUser(int $userId): void
    {
        $command = new DeleteUserCommand($userId);

        $this->publish($command);
    }

    public function publishCommandWithUserAddedEventHandler(CommandInterface $command): int
    {
        $handler = new class implements AppEventHandlerInterface {
            private int $userId;

            public function handle(AppEventInterface $event): void
            {
                if ($event instanceof UserAddedEvent)
                {
                    $this->userId = $event->getUserId();
                }
            }

            public function getUserId(): int
            {
                return $this->userId;
            }
        };

        $this->eventSource->subscribe($handler);

        try
        {
            $this->publish($command);
        }
        finally
        {
            $this->eventSource->unsubscribe($handler);
        }

        return $handler->getUserId();
    }


    private function publish(CommandInterface $command): void
    {
        try
        {
            $this->commandBus->publish($command);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}