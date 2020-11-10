<?php

namespace App\Module\User\Api\Mapper;

use App\Module\User\Api\Output\UserOutput;
use App\Module\User\App\Data\UserData;

class UserMapper
{
    public static function getUserOutput(UserData $data): UserOutput
    {
        return new UserOutput(
            $data->getId(),
            $data->getUsername(),
            $data->getPassword(),
            $data->getEmail(),
            $data->getCreatedAt()
        );
    }
}