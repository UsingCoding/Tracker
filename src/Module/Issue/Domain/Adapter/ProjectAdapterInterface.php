<?php

namespace App\Module\Issue\Domain\Adapter;

use App\Module\Project\Domain\Model\Project;

interface ProjectAdapterInterface
{
    public function getProjectById(int $projectId): ?Project;
}