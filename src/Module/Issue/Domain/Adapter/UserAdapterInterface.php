<?php

namespace App\Module\Issue\Domain\Adapter;

use App\Module\Issue\Domain\Model\User;

interface UserAdapterInterface
{
    public function getUserById(int $userId): ?User;
}