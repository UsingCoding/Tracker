<?php

namespace App\View;

use App\Common\App\View\RenderableTrait;
use App\Common\App\View\RenderableViewInterface;
use App\Module\Project\Api\Output\ProjectOutput;
use Symfony\Component\HttpFoundation\Response;

class ProjectView implements RenderableViewInterface
{
    use RenderableTrait;

    private ProjectOutput $project;
    private int $loggedUserId;

    public function __construct(ProjectOutput $project, int $loggedUserId)
    {
        $this->project = $project;
        $this->loggedUserId = $loggedUserId;
    }

    public function render(): Response
    {
        return $this->json([
            'name' => $this->project->getName(),
            'nameId' => $this->project->getNameId(),
            'description' => $this->project->getDescription(),
            'owner_id' => $this->project->getOwnerId(),
            'is_owner' => $this->project->getOwnerId() === $this->loggedUserId
        ]);
    }
}