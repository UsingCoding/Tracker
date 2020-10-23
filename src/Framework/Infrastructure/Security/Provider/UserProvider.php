<?php

namespace App\Framework\Infrastructure\Security\Provider;

use App\Framework\Infrastructure\Security\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function loadUserByUsername(string $username)
    {
        return new User();
    }

    public function refreshUser(UserInterface $user)
    {
        return new User();
    }

    public function supportsClass(string $class)
    {
        return User::class === $class;
    }
}