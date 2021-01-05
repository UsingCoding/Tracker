<?php

namespace App\Module\Project\App\Query;

use App\Module\Project\App\Data\ProjectListItemData;

interface ProjectQueryServiceInterface
{
    /**
     * @param int $userId
     * @return ProjectListItemData[]
     */
    public function listForUser(int $userId): array;
}