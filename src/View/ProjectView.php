<?php

namespace App\View;

use App\Common\App\View\RenderableTrait;
use App\Common\App\View\RenderableViewInterface;
use App\Framework\Infrastructure\Security\User\User;
use App\Module\Project\Api\Output\ProjectOutput;
use App\Module\Statistics\Api\Output\ProjectStatisticsOutput;
use Symfony\Component\HttpFoundation\Response;

class ProjectView implements RenderableViewInterface
{
    use RenderableTrait;

    private ProjectOutput $project;
    private ProjectStatisticsOutput $statistics;
    private User $loggedUser;

    public function __construct(ProjectOutput $project, ProjectStatisticsOutput $statistics, User $loggedUser)
    {
        $this->project = $project;
        $this->statistics = $statistics;
        $this->loggedUser = $loggedUser;
    }

    public function render(): Response
    {
        return $this->json([
            'name' => $this->project->getName(),
            'nameId' => $this->project->getNameId(),
            'description' => $this->project->getDescription(),
            'owner_id' => $this->project->getOwnerId(),
            'is_owner' => $this->project->getOwnerId() === $this->loggedUser->getUserOutput()->getUserId(),
            'user_to_issues_count' => $this->statistics->getUserToIssuesCountMap()
        ]);
    }
}