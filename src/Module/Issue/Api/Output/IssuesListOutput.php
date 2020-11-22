<?php

namespace App\Module\Issue\Api\Output;

class IssuesListOutput
{
    /** @var IssueListItemOutput[] */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}