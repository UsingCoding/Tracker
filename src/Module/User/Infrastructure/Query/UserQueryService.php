<?php

namespace App\Module\User\Infrastructure\Query;

use App\Module\User\App\Data\UserData;
use App\Module\User\App\Exception\UserNotFoundException;
use App\Module\User\App\Query\UserQueryServiceInterface;
use App\Module\User\Domain\Model\Mapper\UserMapper;
use App\Module\User\Domain\Model\UserRepositoryInterface;

class UserQueryService implements UserQueryServiceInterface
{
    private UserRepositoryInterface $userRepo;

    public function getUserById(int $userId): UserData
    {
        $user = $this->userRepo->findById($userId);

        if ($user === null)
        {
            throw new UserNotFoundException('');
        }

        return UserMapper::getUserData($user);
    }

    public function getUserByUsername(string $username): UserData
    {
        $user = $this->userRepo->findByUsername($username);

        if ($user === null)
        {
            throw new UserNotFoundException('');
        }

        return UserMapper::getUserData($user);
    }
}