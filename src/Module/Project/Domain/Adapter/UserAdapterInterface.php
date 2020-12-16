<?php

namespace App\Module\Project\Domain\Adapter;

use App\Module\Project\Domain\Model\User;

interface UserAdapterInterface
{
    public function getUserById(int $userId): ?User;
}