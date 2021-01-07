<?php

namespace App\View;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Domain\Utils\Arrays;
use App\Framework\Infrastructure\Security\User\User;
use App\Module\Project\Api\Output\ProjectOutput;
use App\Module\Project\Api\Output\TeamMemberListOutput;
use App\Module\Project\Api\Output\TeamMemberOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TeamMemberListView implements RenderableViewInterface
{
    private TeamMemberListOutput $list;
    private ProjectOutput $project;
    private User $loggedUser;

    public function __construct(TeamMemberListOutput $list, ProjectOutput $project, User $loggedUser)
    {
        $this->list = $list;
        $this->project = $project;
        $this->loggedUser = $loggedUser;
    }

    public function render(): Response
    {
        return new JsonResponse([
            'project_name' => $this->project->getName(),
            'team_members' => Arrays::map($this->list->getMembers(),
                fn(TeamMemberOutput $output) => [
                    'team_member_id' => $output->getId(),
                    'user_id' => $output->getUserId(),
                    'is_owner' => $output->getUserId() === $this->loggedUser->getUserOutput()->getUserId(),
                    'username' => $output->getUsername()
                ]
            )
        ]);
    }
}