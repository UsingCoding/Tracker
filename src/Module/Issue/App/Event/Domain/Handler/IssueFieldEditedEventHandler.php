<?php

namespace App\Module\Issue\App\Event\Domain\Handler;

use App\Common\Domain\Event\DomainEventInterface;
use App\Common\Domain\Event\TypedDomainEventHandler;
use App\Module\Issue\Domain\Event\IssueFieldEdited;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;
use App\Module\Issue\Domain\Service\IssueService;

class IssueFieldEditedEventHandler extends TypedDomainEventHandler
{
    private IssueService $issueService;
    private IssueRepositoryInterface $issueRepo;

    public function __construct(
        string $type,
        IssueService $issueService,
        IssueRepositoryInterface $issueRepo
    )
    {
        parent::__construct($type);

        $this->issueService = $issueService;
        $this->issueRepo = $issueRepo;
    }

    public function handle(DomainEventInterface $event): void
    {
        if (!$event instanceof IssueFieldEdited)
        {
            return;
        }

        $issues = $this->issueRepo->findForProject($event->getProjectId());

        foreach ($issues as $issue)
        {

        }
    }
}