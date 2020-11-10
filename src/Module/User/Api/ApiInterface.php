<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Output\UserOutput;

interface ApiInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return UserOutput
     * @throws ApiException
     */
    public function authorizeUserByEmail(string $email, string $password): UserOutput;

    /**
     * @param int $userId
     * @return UserOutput
     * @throws ApiException
     */
    public function getUserById(int $userId): UserOutput;

    /**
     * @param string $userName
     * @return UserOutput
     * @throws ApiException
     */
    public function getUserByUsername(string $userName): UserOutput;
}