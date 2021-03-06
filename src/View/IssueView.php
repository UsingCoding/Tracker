<?php

namespace App\View;

use App\Common\Domain\Utils\Arrays;
use App\Common\Domain\Utils\Date;
use App\Common\Infrastructure\Context\AvatarUrlProvider;
use App\Module\Issue\Api\Output\CommentOutput;
use App\Module\Issue\Api\Output\GetIssueOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IssueView
{
    private GetIssueOutput $issue;
    private AvatarUrlProvider $avatarUrlProvider;

    public function __construct(GetIssueOutput $issue, AvatarUrlProvider $avatarUrlProvider)
    {
        $this->issue = $issue;
        $this->avatarUrlProvider = $avatarUrlProvider;
    }

    public function render(): Response
    {
        $data = [
            'issue_id' => $this->issue->getIssueId(),
            'in_project_id' => $this->issue->getInProjectId(),
            'name' => $this->issue->getName(),
            'description' => $this->issue->getDescription(),
            'created_at' => $this->issue->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
            'updated_at' => $this->issue->getUpdatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
            'project' => [
                'id' => $this->issue->getProject()->getId(),
                'name' => $this->issue->getProject()->getName()
            ],
            'fields' => $this->issue->getFields(),
            'comments' => Arrays::map(
                $this->issue->getComments(),
                fn(CommentOutput $output) => [
                    'id' => $output->getId(),
                    'username' => $output->getUsername(),
                    'content' => $output->getContent(),
                    'created_at' => $output->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
                    'updated_at' => $output->getUpdatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
                    'avatar_url' => $this->avatarUrlProvider->getUrl($output->getUserAvatarUrl())
                ]
            )
        ];

        if (null !== $assigneeUser = $this->issue->getAssigneeUser())
        {
            $data['user'] = [
                'id' => $assigneeUser->getId(),
                'username' => $assigneeUser->getUsername()
            ];
        }

        return new JsonResponse($data);
    }
}