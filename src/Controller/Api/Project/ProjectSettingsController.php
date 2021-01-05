<?php

namespace App\Controller\Api\Project;

use App\Controller\Api\ApiController;
use App\Controller\Api\Exception\NoLoggedUserException;
use App\Module\Project\Api\ApiInterface as ProjectApiInterface;
use App\Module\Project\Api\Exception\ApiException;
use App\View\ProjectsListView;
use Symfony\Component\HttpFoundation\Response;

class ProjectSettingsController extends ApiController
{
    /**
     * @param ProjectApiInterface $api
     * @return Response
     * @throws ApiException
     * @throws NoLoggedUserException
     */
    public function projectsListForUser(ProjectApiInterface $api): Response
    {
        $list = $api->projectsListForUser($this->getLoggedUser()->getUserOutput()->getUserId());

        $view = new ProjectsListView($list);

        return $view->render();
    }
}