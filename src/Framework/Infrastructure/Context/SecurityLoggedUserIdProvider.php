<?php

namespace App\Framework\Infrastructure\Context;

use App\Common\App\Context\LoggedUserIdProviderInterface;
use App\Framework\Infrastructure\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityLoggedUserIdProvider implements LoggedUserIdProviderInterface
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getUserId(): ?int
    {
        $token = $this->tokenStorage->getToken();

        if ($token === null)
        {
            return null;
        }

        $user = $token->getUser();

        if ($user === null)
        {
            return null;
        }

        if (!$user instanceof User)
        {
            return null;
        }

        return $user->getUserOutput()->getUserId();
    }
}