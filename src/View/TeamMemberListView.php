<?php

namespace App\View;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Project\Api\Output\TeamMemberListOutput;
use App\Module\Project\Api\Output\TeamMemberOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TeamMemberListView implements RenderableViewInterface
{
    private TeamMemberListOutput $list;

    public function __construct(TeamMemberListOutput $list)
    {
        $this->list = $list;
    }

    public function render(): Response
    {
        return new JsonResponse((array) Arrays::map($this->list->getMembers(),
            static fn(TeamMemberOutput $output) => [
                'team_member_id' => $output->getId(),
                'user_id' => $output->getUserId(),
                'username' => $output->getUsername()
            ]
        ));
    }
}