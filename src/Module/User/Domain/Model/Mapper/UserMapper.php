<?php

namespace App\Module\User\Domain\Model\Mapper;

use App\Module\User\App\Data\UserData;
use App\Module\User\Domain\Model\User;

class UserMapper
{
    public static function getUserData(User $user): UserData
    {
        return new UserData(
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getCreatedAt(),
            $user->getEmail(),
            $user->getGrade()
        );
    }
}