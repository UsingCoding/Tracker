<?php

namespace App\View;

use App\Common\Domain\Utils\Arrays;
use App\Module\Project\Api\Output\ProjectOutput;
use App\Module\Project\Api\Output\ProjectsListOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectsListView
{
    private ProjectsListOutput $list;

    public function __construct(ProjectsListOutput $list)
    {
        $this->list = $list;
    }


    public function render(): Response
    {
        return new JsonResponse(Arrays::map($this->list->getProjects(),
            static fn(ProjectOutput $output) => [
                'project_id' => $output->getId(),
                'name' => $output->getName(),
                'name_id' => $output->getNameId(),
                'description' => $output->getDescription()
            ]
        ));
    }
}