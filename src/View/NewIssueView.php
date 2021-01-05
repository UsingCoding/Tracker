<?php

namespace App\View;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\IssueFieldListOutput;
use App\Module\Issue\Api\Output\IssueFieldOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NewIssueView implements RenderableViewInterface
{
    private IssueFieldListOutput $fieldListOutput;

    public function __construct(IssueFieldListOutput $fields)
    {
        $this->fieldListOutput = $fields;
    }

    public function render(): Response
    {
        return new JsonResponse([
            'fields' => Arrays::map(
                $this->fieldListOutput->getIssuesFields(),
                static fn(IssueFieldOutput $output) => $output->getName()
            )
        ]);
    }
}