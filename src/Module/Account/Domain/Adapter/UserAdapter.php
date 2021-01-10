<?php

namespace App\Module\Account\Domain\Adapter;

use App\Module\Project\Domain\Model\User;
use App\Module\User\Domain\Model\UserRepositoryInterface;

class UserAdapter implements UserAdapterInterface
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getUserById(int $userId): ?User
    {
        $user =  $this->userRepo->findById($userId);

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