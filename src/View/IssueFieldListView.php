<?php

namespace App\View;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\IssueFieldListOutput;
use App\Module\Issue\Api\Output\IssueFieldOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IssueFieldListView
{
    private IssueFieldListOutput $list;

    public function __construct(IssueFieldListOutput $list)
    {
        $this->list = $list;
    }

    public function render(): Response
    {
        return new JsonResponse((array) Arrays::map($this->list->getIssuesFields(),
            static fn(IssueFieldOutput $output) => [
                'id' => $output->getId(),
                'name' => $output->getName(),
                'type' => $output->getType()
            ])
        );
    }
}