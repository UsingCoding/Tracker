<?php

namespace App\Module\Issue\App\Event\Domain\Handler;

use App\Common\Domain\Event\DomainEventInterface;
use App\Common\Domain\Event\TypedDomainEventHandler;
use App\Module\Issue\Domain\Event\IssueFieldEdited;
use App\Module\Issue\Domain\Service\IssueService;

class IssueFieldEditedEventHandler extends TypedDomainEventHandler
{
    private IssueService $issueService;

    public function __construct(string $type, IssueService $issueService)
    {
        parent::__construct($type);

        $this->issueService = $issueService;
    }

    public function handle(DomainEventInterface $event): void
    {
        if (!$event instanceof IssueFieldEdited)
        {
            return;
        }

        if ($event->getFieldType() === null)
        {
            return;
        }

        $this->issueService->editFieldInIssues($event->getId(), $event->getProjectId());
    }
}