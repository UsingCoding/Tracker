<?php

namespace App\Controller\Api\Project;

use App\Controller\Api\ApiController;
use App\Module\Project\Api\ApiInterface as ProjectApiInterface;
use App\View\ProjectsListView;
use Symfony\Component\HttpFoundation\Response;

class ProjectSettingsController extends ApiController
{
    public function projectsList(ProjectApiInterface $api): Response
    {
        $list = $api->projectsList();

        $view = new ProjectsListView($list);

        return $view->render();
    }
}