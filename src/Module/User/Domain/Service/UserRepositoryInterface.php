<?php

namespace App\Module\User\Domain\Service;

interface UserRepositoryInterface
{
    public function getUserByEmail(string $email): void;
}