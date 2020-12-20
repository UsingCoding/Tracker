<?php

namespace App\Module\Assignment\App\Service;

use App\Common\App\Synchronization\ScheduledJobsQueueInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Assignment\App\Adapter\IssueAdapterInterface;
use App\Module\Assignment\App\Data\IssueField;
use App\Module\Assignment\App\Data\IssueWithFieldsData;
use App\Module\Assignment\App\Exception\AutoAssigmentNotAvailableException;
use App\Module\Assignment\App\Exception\FailedToGetIssueFieldsListException;
use App\Module\Assignment\App\Exception\IssueInternalException;
use Psr\Log\LoggerInterface;

class AssigmentService
{
    private const ESTIMATION_FIELD_NAME = 'estimation';
    private const DIFFICULTY_FIELD_NAME = 'difficulty';

    private IssueAdapterInterface $issueAdapter;
    private AssigmentQueryService $assigmentQueryService;
    private ScheduledJobsQueueInterface $scheduledJobsQueue;
    private LoggerInterface $logger;

    public function __construct(
        IssueAdapterInterface $issueAdapter,
        AssigmentQueryService $assigmentQueryService,
        ScheduledJobsQueueInterface $scheduledJobsQueue,
        LoggerInterface $logger
    )
    {
        $this->issueAdapter = $issueAdapter;
        $this->assigmentQueryService = $assigmentQueryService;
        $this->scheduledJobsQueue = $scheduledJobsQueue;
        $this->logger = $logger;
    }

    /**
     * @param int $projectId
     * @return int
     * @throws FailedToGetIssueFieldsListException
     * @throws AutoAssigmentNotAvailableException
     * @throws IssueInternalException
     */
    public function autoAssigneeIssuesInProject(int $projectId): int
    {
        $fields = $this->issueAdapter->getFields($projectId);

        if (!$this->assigmentQueryService->fieldsListSatisfyRequirements($fields))
        {
            throw new AutoAssigmentNotAvailableException('Auto assigment for project not available', ['project_id' => $projectId]);
        }

        $issues = $this->issueAdapter->findIssuesForProject($projectId);

        $this->scheduledJobsQueue->addJob(fn() => $this->autoAssigneeImpl($issues, $fields));

        return Arrays::length($issues);
    }

    /**
     * @param IssueWithFieldsData[] $issues
     * @param IssueField[] $fields
     */
    private function autoAssigneeImpl(array $issues, array $fields): void
    {
        $this->logger->debug('CALLED');
    }
}