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
        return new JsonResponse(Arrays::map($this->list, static fn(IssueListItemOutput $item) => [
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'created_at' => $item->getCreatedAt(),
            'updated_at' => $item->getUpdatedAt()
        ]));
    }
}