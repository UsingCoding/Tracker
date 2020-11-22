<?php

namespace App\View;

use App\Common\Domain\Utils\Date;
use App\Module\Issue\Api\Output\GetIssueOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IssueView
{
    private GetIssueOutput $issue;

    public function __construct(GetIssueOutput $issue)
    {
        $this->issue = $issue;
    }

    public function render(): Response
    {
        return new JsonResponse([
            'issue_id' => $this->issue->getIssueId(),
            'name' => $this->issue->getName(),
            'project_name' => $this->issue->getProjectName(),
            'username' => $this->issue->getUsername(),
            'description' => $this->issue->getDescription(),
            'created_at' => $this->issue->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
            'updated_at' => $this->issue->getUpdatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT)
        ]);
    }
}