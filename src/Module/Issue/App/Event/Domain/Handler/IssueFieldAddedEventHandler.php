<?php

namespace App\Module\Issue\App\Event\Domain\Handler;

use App\Common\Domain\Event\DomainEventInterface;
use App\Common\Domain\Event\TypedDomainEventHandler;
use App\Module\Issue\Domain\Event\IssueFieldAdded;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;
use App\Module\Issue\Domain\Service\IssueService;

class IssueFieldAddedEventHandler extends TypedDomainEventHandler
{
    private const NEW_FIELD_DEFAULT_VALUE = 'null';

    private IssueService $issueService;
    private IssueRepositoryInterface $repo;

    public function __construct(string $type, IssueService $issueService, IssueRepositoryInterface $repo)
    {
        parent::__construct($type);

        $this->issueService = $issueService;
        $this->repo = $repo;
    }

    public function handle(DomainEventInterface $event): void
    {
        if (!$event instanceof IssueFieldAdded)
        {
            return;
        }

        $issues = $this->repo->findForProject($event->getProjectId());

        foreach ($issues as $issue)
        {
            $this->issueService->editIssue(
                $issue->getId(),
                null,
                null,
                null,
                null,
                [$event->getId() => self::NEW_FIELD_DEFAULT_VALUE]
            );
        }
    }
}