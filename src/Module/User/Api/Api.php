<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Mapper\UserMapper;
use App\Module\User\Api\Output\UserOutput;
use App\Module\User\App\Service\AuthenticationService;

class Api implements ApiInterface
{
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
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
}