<?php

namespace App\Module\User\Domain\Service;

use App\Module\User\App\Data\UserData;
use App\Module\User\Domain\Model\Mapper\UserMapper;
use App\Module\User\Domain\Model\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(int $userId): ?UserData
    {
        $user = $this->userRepository->findById($userId);

        if ($user === null)
        {
            return null;
        }

        return UserMapper::getUserData($user);
    }

    public function getUserByEmail(string $email): ?UserData
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null)
        {
            return null;
        }

        return UserMapper::getUserData($user);
    }
}