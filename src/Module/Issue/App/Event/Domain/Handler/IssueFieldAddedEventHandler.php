<?php

namespace App\Module\Issue\App\Event\Domain\Handler;

use App\Common\Domain\Event\DomainEventInterface;
use App\Common\Domain\Event\TypedDomainEventHandler;
use App\Module\Issue\Domain\Event\IssueFieldAdded;
use App\Module\Issue\Domain\Service\IssueService;

class IssueFieldAddedEventHandler extends TypedDomainEventHandler
{
    private IssueService $issueService;

    public function __construct(string $type, IssueService $issueService)
    {
        parent::__construct($type);

        $this->issueService = $issueService;
    }

    public function handle(DomainEventInterface $event): void
    {
        if (!$event instanceof IssueFieldAdded)
        {
            return;
        }

        $this->issueService->addFieldToIssues($event->getName(), $event->getProjectId());
    }
}