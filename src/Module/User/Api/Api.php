<?php

namespace App\Module\User\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Input\AddUserInput;
use App\Module\User\Api\Input\EditUserInput;
use App\Module\User\Api\Mapper\UserMapper;
use App\Module\User\Api\Output\UserListOutput;
use App\Module\User\Api\Output\UserOutput;
use App\Module\User\App\Command\AddUserCommand;
use App\Module\User\App\Command\EditUserCommand;
use App\Module\User\App\Query\UserQueryServiceInterface;
use App\Module\User\App\Service\AuthenticationService;

class Api implements ApiInterface
{
    private AuthenticationService $authenticationService;
    private UserQueryServiceInterface $userQueryService;
    private AppCommandBusInterface $commandBus;

    public function __construct(
        AuthenticationService $authenticationService, 
        UserQueryServiceInterface $userQueryService, 
        AppCommandBusInterface $userCommandBus
    )
    {
        $this->authenticationService = $authenticationService;
        $this->userQueryService = $userQueryService;
        $this->commandBus = $userCommandBus;
    }

    public function authorizeUserByEmail(string $email, string $password): UserOutput
    {
        try
        {
            return UserMapper::getUserOutput($this->authenticationService->authenticate($email, $password));
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

    public function addUser(AddUserInput $input): void
    {
        $command = new AddUserCommand($input);

        $this->publish($command);
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