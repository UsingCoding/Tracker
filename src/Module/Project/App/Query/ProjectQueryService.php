<?php

namespace App\Module\Project\App\Query;

use App\Module\Project\App\Data\ProjectData;
use App\Module\Project\App\Data\ProjectDataMapper;
use App\Module\Project\App\Exception\ProjectNotExistsException;
use App\Module\Project\Domain\Service\ProjectService;

class ProjectQueryService
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @param int $id
     * @return ProjectData
     * @throws ProjectNotExistsException
     */
    public function getProjectData(int $id): ProjectData
    {
        $project = $this->projectService->getProject($id);

        if ($project === null)
        {
            throw new ProjectNotExistsException('', ['id' => $id]);
        }

        return ProjectDataMapper::getProjectData($project);
    }
}