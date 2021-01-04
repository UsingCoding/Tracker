<?php

namespace App\Controller\Api\Project;

use App\Controller\Api\ApiController;
use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Input\EditProjectInput;
use App\Module\Project\Api\ProjectManagementApiInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectManagementController extends ApiController
{
    /**
     * @param int $id
     * @param ProjectManagementApiInterface $api
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
                return $this->json(['error' => 'project_not_exists'], Response::HTTP_NOT_FOUND);
            }

            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param ProjectManagementApiInterface $api
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
                $request->get('owner_id'),
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

            if ($e->getType() === ApiException::USER_NOT_EXISTS)
            {
                return $this->json(['error' => 'user_not_exists']);
            }

            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param ProjectManagementApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function editProject(Request $request, ProjectManagementApiInterface $api): Response
    {
        try
        {
            $api->editProject(new EditProjectInput(
                $request->get('project_id'),
                $request->get('name'),
                $request->get('description')
            ));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::PROJECT_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'project_by_id_not_found']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param ProjectManagementApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function deleteProject(Request $request, ProjectManagementApiInterface $api): Response
    {
        try
        {
            $api->deleteProject($request->get('project_id'));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::PROJECT_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'project_by_id_not_found']);
            }

            throw $exception;
        }
    }
}