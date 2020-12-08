<?php

namespace App\Module\Project\App\Query;

use App\Module\Project\App\Data\ProjectListItemData;

interface ProjectQueryServiceInterface
{
    /**
     * @return ProjectListItemData[]
     */
    public function list(): array;
}