<?php

namespace App\View;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\IssueListItemOutput;
use App\Module\Issue\Api\Output\IssuesListOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IssuesListView
{
    private IssuesListOutput $list;

    public function __construct(IssuesListOutput $list)
    {
        $this->list = $list;
    }

    public function render(): Response
    {
        return new JsonResponse(Arrays::map($this->list->getItems(), static fn(IssueListItemOutput $item) => [
            'issue_id' => $item->getIssueId(),
            'issue_code' => $item->getIssueCode(),
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'username' => $item->getAssigneeUsername(),
            'project_name_id' => $item->getProjectNameId(),
            'fields' => $item->getFields(),
            'updated_at' => $item->getUpdatedAt()->format('d M Y G:i')
        ]));
    }
}