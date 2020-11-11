<?php

namespace App\Controller\Api\Project;

use App\Controller\Api\ApiController;
use App\Module\Project\Api\ProjectManagementApiInterface;
use Symfony\Component\HttpFoundation\Response;

class ProjectManagementController extends ApiController
{
    public function getProject(int $id, ProjectManagementApiInterface $api): Response
    {
        $project = $api->getProject($id);

        return $this->json([
            'name' => $project->getName(),
            'nameId' => $project->getNameId(),
            'description' => $project->getDescription()
        ]);
    }
}