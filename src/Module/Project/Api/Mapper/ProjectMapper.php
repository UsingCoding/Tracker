<?php

namespace App\Module\Project\Api\Mapper;

use App\Module\Project\Api\Output\GetProjectOutput;
use App\Module\Project\App\Data\ProjectData;

class ProjectMapper
{
    public static function getProjectOutput(ProjectData $data): GetProjectOutput
    {
        return new GetProjectOutput(
            $data->getId(),
            $data->getName(),
            $data->getNameId(),
            $data->getDescription()
        );
    }
}