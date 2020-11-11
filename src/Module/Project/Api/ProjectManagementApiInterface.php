<?php

namespace App\Module\Project\Api;

use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Output\GetProjectOutput;

interface ProjectManagementApiInterface
{
    /**
     * @param CreateProjectInput $input
     * @throws ApiException
     */
    public function createProject(CreateProjectInput $input): void;

    /**
     * @param int $id
     * @return GetProjectOutput
     * @throws ApiException
     */
    public function getProject(int $id): GetProjectOutput;
}