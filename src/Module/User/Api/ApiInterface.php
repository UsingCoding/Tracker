<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Input\AddUserInput;
use App\Module\User\Api\Input\EditUserInput;
use App\Module\User\Api\Output\UserListOutput;
use App\Module\User\Api\Output\UserOutput;

interface ApiInterface
{
    /**
     * @param string $usernameOrEmail
     * @param string $password
     * @return UserOutput
     * @throws ApiException
     */
    public function authorizeUserByEmail(string $usernameOrEmail, string $password): UserOutput;

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

    /**
     * @param AddUserInput $input
     * @return int
     * @throws ApiException
     */
    public function addUser(AddUserInput $input): int;

    /**
     * @param EditUserInput $input
     * @throws ApiException
     */
    public function editUser(EditUserInput $input): void;

    /**
     * @param int $userId
     * @throws ApiException
     */
    public function deleteUser(int $userId): void;

    /**
     * @return UserListOutput
     * @throws ApiException
     */
    public function list(): UserListOutput;
}