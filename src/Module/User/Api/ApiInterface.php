<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Output\UserOutput;

interface ApiInterface
{
    public function authorizeUserByEmail(string $email, string $password): UserOutput;
}