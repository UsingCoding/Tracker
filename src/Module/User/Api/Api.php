<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Mapper\UserMapper;
use App\Module\User\Api\Output\UserOutput;
use App\Module\User\App\Query\UserQueryServiceInterface;
use App\Module\User\App\Service\AuthenticationService;

class Api implements ApiInterface
{
    private AuthenticationService $authenticationService;
    private UserQueryServiceInterface $userQueryService;

    public function __construct(AuthenticationService $authenticationService, UserQueryServiceInterface $userQueryService)
    {
        $this->authenticationService = $authenticationService;
        $this->userQueryService = $userQueryService;
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
}