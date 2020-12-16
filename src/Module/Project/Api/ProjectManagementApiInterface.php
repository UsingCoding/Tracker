<?php

namespace App\Module\Project\Api;

use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Input\EditProjectInput;
use App\Module\Project\Api\Output\ProjectOutput;

interface ProjectManagementApiInterface
{
    /**
     * @param CreateProjectInput $input
     * @throws ApiException
     */
    public function createProject(CreateProjectInput $input): void;

    /**
     * @param int $id
     * @return ProjectOutput
     * @throws ApiException
     */
    public function getProject(int $id): ProjectOutput;

    /**
     * @param EditProjectInput $input
     * @throws ApiException
     */
    public function editProject(EditProjectInput $input): void;

    /**
     * @param int $projectId
     * @throws ApiException
     */
    public function deleteProject(int $projectId): void;
}