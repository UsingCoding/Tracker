<?php

namespace App\Module\User\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\User\Api\Output\UserListOutput;
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
            $data->getCreatedAt(),
            $data->getGrade(),
            $data->getAvatarUrl()
        );
    }

    /**
     * @param UserData[] $list
     * @return UserListOutput
     */
    public static function getUserListOutput(array $list): UserListOutput
    {
        return new UserListOutput((array) Arrays::map($list,
            static fn(UserData $data) => new UserOutput(
                $data->getId(),
                $data->getUsername(),
                $data->getPassword(),
                $data->getEmail(),
                $data->getCreatedAt(),
                $data->getGrade(),
                $data->getAvatarUrl()
            )
        ));
    }
}