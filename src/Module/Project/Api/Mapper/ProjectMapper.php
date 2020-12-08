<?php

namespace App\Module\Project\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Project\Api\Output\ProjectOutput;
use App\Module\Project\Api\Output\ProjectsListOutput;
use App\Module\Project\App\Data\ProjectData;
use App\Module\Project\App\Data\ProjectListItemData;

class ProjectMapper
{
    public static function getProjectOutput(ProjectData $data): ProjectOutput
    {
        return new ProjectOutput(
            $data->getId(),
            $data->getName(),
            $data->getNameId(),
            $data->getDescription()
        );
    }

    /**
     * @param ProjectListItemData[] $list
     * @return ProjectsListOutput
     */
    public static function getProjectListOutput(array $list): ProjectsListOutput
    {
        return new  ProjectsListOutput((array) Arrays::map($list,
            static fn(ProjectListItemData $data) => new ProjectOutput(
                $data->getId(),
                $data->getName(),
                $data->getNameId(),
                $data->getDescription()
            )
        ));
    }
}