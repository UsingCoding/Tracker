<?php

namespace App\Module\Issue\App\Event\Domain\Handler;

use App\Common\Domain\Event\DomainEventInterface;
use App\Common\Domain\Event\TypedDomainEventHandler;
use App\Module\Issue\Domain\Event\IssueFieldDeleted;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;

class IssueFieldDeletedEventHandler extends TypedDomainEventHandler
{
    private IssueRepositoryInterface $issueRepo;

    public function __construct(
        string $type,
        IssueRepositoryInterface $issueRepo
    )
    {
        parent::__construct($type);

       $this->issueRepo = $issueRepo;
    }

    public function handle(DomainEventInterface $event): void
    {
        if (!$event instanceof IssueFieldDeleted)
        {
            return;
        }

        $issues =  $this->issueRepo->findForProject($event->getProjectId());
    }
}