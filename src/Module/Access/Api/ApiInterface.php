<?php

namespace App\Module\Access\Api;

interface ApiInterface
{
    public function userHasProjectAccess(int $userId, int $projectId): bool;
}