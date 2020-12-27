<?php

namespace App\View;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\IssueFieldListOutput;
use App\Module\Issue\Api\Output\IssueFieldOutput;
use App\Module\Project\Api\Output\ProjectOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IssueFieldListView implements RenderableViewInterface
{
    private IssueFieldListOutput $list;
    private ProjectOutput $project;

    public function __construct(IssueFieldListOutput $list, ProjectOutput $project)
    {
        $this->list = $list;
        $this->project = $project;
    }

    public function render(): Response
    {
        return new JsonResponse([
            'project_name' => $this->project->getName(),
            'fields' => Arrays::map($this->list->getIssuesFields(),
                static fn(IssueFieldOutput $output) => [
                    'id' => $output->getId(),
                    'name' => $output->getName(),
                    'type' => $output->getType()
                ])
        ]);
    }
}