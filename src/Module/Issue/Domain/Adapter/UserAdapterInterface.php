<?php

namespace App\Module\Issue\Domain\Adapter;

use App\Module\User\Domain\Model\User;

interface UserAdapterInterface
{
    public function getUserById(int $userId): ?User;
}