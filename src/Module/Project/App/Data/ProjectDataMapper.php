<?php

namespace App\Module\Project\App\Data;

use App\Module\Project\Domain\Model\Project;

class ProjectDataMapper
{
    public static function getProjectData(Project $project): ProjectData
    {
        return new ProjectData(
            $project->getId(),
            $project->getName(),
            $project->getNameId(),
            $project->getOwnerId(),
            $project->getDescription()
        );
    }
}