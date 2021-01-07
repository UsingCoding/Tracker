<?php

namespace App\Controller\Api\Project;

use App\Common\App\View\RenderableViewInterface;
use App\Controller\Api\ApiController;
use App\Controller\Api\Exception\NoLoggedUserException;
use App\Module\Project\Api\Exception\ApiException as ProjectApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Input\EditProjectInput;
use App\Module\Project\Api\ProjectManagementApiInterface;
use App\Module\Statistics\Api\ApiInterface as StatisticsApi;
use App\Module\Statistics\Api\Exception\ApiException as StatisticsApiException;
use App\View\ProjectView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectManagementController extends ApiController
{
    /**
     * @param int $id
     * @param ProjectManagementApiInterface $projectManagementApi
     * @param StatisticsApi $statisticsApi
     * @return RenderableViewInterface
     * @throws ProjectApiException
     * @throws NoLoggedUserException
     * @throws StatisticsApiException
     */
    public function getProject(int $id, ProjectManagementApiInterface $projectManagementApi, StatisticsApi $statisticsApi): RenderableViewInterface
    {
        try
        {
            $project = $projectManagementApi->getProject($id);
            $statistics = $statisticsApi->getProjectStatistics($id);

            return new ProjectView(
                $project,
                $statistics,
                $this->getLoggedUser()
            );
        }
        catch (ProjectApiException $e)
        {
            if ($e->getType() === ProjectApiException::PROJECT_NOT_EXISTS)
            {
                return $this->renderableJson(['error' => 'project_not_exists'], Response::HTTP_NOT_FOUND);
            }

            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param ProjectManagementApiInterface $api
     * @return Response
     * @throws ProjectApiException
     * @throws NoLoggedUserException
     */
    public function createProject(Request $request, ProjectManagementApiInterface $api): Response
    {
        try
        {
            $api->createProject(new CreateProjectInput(
                $request->get('name'),
                $request->get('nameId'),
                $this->getLoggedUser()->getUserOutput()->getUserId(),
                $request->get('description')
            ));

            return $this->json(['success' => 1]);
        }
        catch (ProjectApiException $e)
        {
            if ($e->getType() === ProjectApiException::DUPLICATE_PROJECT_NAME_ID)
            {
                return $this->json(['error' => 'duplicate_project_name_id']);
            }

            if ($e->getType() === ProjectApiException::USER_NOT_EXISTS)
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
     * @throws ProjectApiException
     * @throws NoLoggedUserException
     */
    public function editProject(Request $request, ProjectManagementApiInterface $api): Response
    {
        try
        {
            $api->editProject(new EditProjectInput(
                $request->get('project_id'),
                $this->getLoggedUser()->getUserOutput()->getUserId(),
                $request->get('new_owner_id'),
                $request->get('name'),
                $request->get('description')
            ));

            return new Response();
        }
        catch (ProjectApiException $exception)
        {
            if ($exception->getType() === ProjectApiException::PROJECT_BY_ID_NOT_FOUND)
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
     * @throws ProjectApiException
     * @throws NoLoggedUserException
     */
    public function deleteProject(Request $request, ProjectManagementApiInterface $api): Response
    {
        try
        {
            $api->deleteProject(
                $request->get('project_id'),
                $this->getLoggedUser()->getUserOutput()->getUserId()
            );

            return new Response();
        }
        catch (ProjectApiException $exception)
        {
            if ($exception->getType() === ProjectApiException::PROJECT_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'project_by_id_not_found']);
            }

            throw $exception;
        }
    }
}