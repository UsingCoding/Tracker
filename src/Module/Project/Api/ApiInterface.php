<?php

namespace App\Module\Project\Api;

use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Output\ProjectsListOutput;

interface ApiInterface extends ProjectManagementApiInterface
{
    /**
     * @return ProjectsListOutput
     * @throws ApiException
     */
    public function projectsList(): ProjectsListOutput;
}