<?php

namespace App\Module\Issue\Domain\Adapter;

use App\Module\Issue\Domain\Model\User;
use App\Module\User\Domain\Model\UserRepositoryInterface;

class UserAdapter implements UserAdapterInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById(int $userId): ?User
    {
        $user = $this->userRepository->findById($userId);

        if ($user === null)
        {
            return null;
        }

        return new User(
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getCreatedAt(),
            $user->getEmail()
        );
    }
}