<?php

namespace App\Framework\Infrastructure\Security\Provider;

use App\Framework\Infrastructure\Security\User\User;
use App\Module\User\Api\ApiInterface as UserApi;
use App\Module\User\Api\Exception\ApiException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private UserApi $userApi;

    public function __construct(UserApi $userApi)
    {
        $this->userApi = $userApi;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        try
        {
            return new User($this->userApi->getUserByUsername($username));
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::USER_NOT_FOUND)
            {
                throw new UsernameNotFoundException('');
            }

            throw $exception;
        }
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!($user instanceof User))
        {
            throw new UnsupportedUserException('');
        }

        try
        {
            return new User($this->userApi->getUserById($user->getUserOutput()->getUserId()));
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::USER_NOT_FOUND)
            {
                throw new UsernameNotFoundException('');
            }

            throw $exception;
        }
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}