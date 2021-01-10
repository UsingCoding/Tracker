<?php

namespace App\Module\User\App\Service;

use App\Module\User\App\Data\UserData;
use App\Module\User\App\Exception\IncorrectUserPasswordException;
use App\Module\User\App\Exception\UserNotFoundException;
use App\Module\User\App\Query\UserQueryServiceInterface;
use Exception;

class AuthenticationService
{
    private UserQueryServiceInterface $userQueryService;

    public function __construct(UserQueryServiceInterface $userQueryService)
    {
        $this->userQueryService = $userQueryService;
    }

    /**
     * @param string $usernameOrEmail
     * @param string $password
     * @return UserData
     * @throws IncorrectUserPasswordException
     * @throws UserNotFoundException
     * @throws Exception
     */
    public function authenticate(string $usernameOrEmail, string $password): UserData
    {
        $user = $this->userQueryService->findByUsernameOrEmail($usernameOrEmail);

        if ($user === null)
        {
            throw new UserNotFoundException('', ['username_or_email' => $usernameOrEmail, 'password' => $password]);
        }

        if ($user->getPassword() !== $password)
        {
            throw new IncorrectUserPasswordException('', ['username_or_email' => $usernameOrEmail, 'password' => $password]);
        }

        return $user;
    }
}