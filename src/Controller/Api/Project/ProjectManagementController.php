<?php

namespace App\Controller\Api\Project;

use App\Controller\Api\ApiController;
use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\ProjectManagementApiInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectManagementController extends ApiController
{
    /**
     * @param int $id
     * @param ProjectManagementApiInterface $api
     * @param LoggerInterface $logger
     * @return Response
     * @throws ApiException
     */
    public function getProject(int $id, ProjectManagementApiInterface $api): Response
    {
        try
        {
            $project = $api->getProject($id);

            return $this->json([
                'name' => $project->getName(),
                'nameId' => $project->getNameId(),
                'description' => $project->getDescription()
            ]);
        }
        catch (ApiException $e)
        {
            if ($e->getType() === ApiException::PROJECT_NOT_EXISTS)
            {
                return $this->json(['error' => 'project_not_exists'], Response::HTTP_NO_CONTENT);
            }

            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param ProjectManagementApiInterface $api
     * @param LoggerInterface $logger
     * @return Response
     * @throws ApiException
     */
    public function createProject(Request $request, ProjectManagementApiInterface $api): Response
    {
        try
        {
            $api->createProject(new CreateProjectInput(
                $request->get('name'),
                $request->get('nameId'),
                $request->get('description')
            ));

            return $this->json(['success' => 1]);
        }
        catch (ApiException $e)
        {
            if ($e->getType() === ApiException::DUPLICATE_PROJECT_NAME_ID)
            {
                return $this->json(['error' => 'duplicate_project_name_id']);
            }

            throw $e;
        }
    }
}