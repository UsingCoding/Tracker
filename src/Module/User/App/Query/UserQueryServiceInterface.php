<?php

namespace App\Module\User\App\Query;

use App\Module\User\App\Data\UserData;
use App\Module\User\App\Exception\UserNotFoundException;
use Exception;

interface UserQueryServiceInterface
{
    /**
     * @param int $userId
     * @return UserData
     * @throws UserNotFoundException
     */
    public function getUserById(int $userId): UserData;

    /**
     * @param string $username
     * @return UserData
     * @throws UserNotFoundException
     */
    public function getUserByUsername(string $username): UserData;

    /**
     * @return UserData[]
     * @throws Exception
     */
    public function getList(): array;
}