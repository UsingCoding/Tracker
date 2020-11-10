<?php

namespace App\Module\User\App\Service;

use App\Module\User\App\Data\UserData;
use App\Module\User\App\Exception\IncorrectUserPasswordException;
use App\Module\User\App\Exception\UserNotFoundException;
use App\Module\User\Domain\Service\UserService;
use Psr\Log\LoggerInterface;

class AuthenticationService
{
    private UserService $userService;
    private LoggerInterface $logger;

    public function __construct(UserService $userService, LoggerInterface $logger)
    {
        $this->userService = $userService;
        $this->logger = $logger;
    }

    public function authenticate(string $email, string $password): UserData
    {
        $user = $this->userService->getUserByEmail($email);

        if ($user === null)
        {
            throw new UserNotFoundException('');
        }

        if ($user->getPassword() !== $password)
        {
            throw new IncorrectUserPasswordException('');
        }

        return $user;
    }
}