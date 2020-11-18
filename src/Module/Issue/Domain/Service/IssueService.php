<?php

namespace App\Module\Issue\Domain\Service;

use App\Module\Issue\Domain\Exception\ProjectToAddIssueNotExistsException;
use App\Module\Issue\Domain\Exception\UserToAssigneeIssueNotExistsException;
use App\Module\Issue\Domain\Model\Issue;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;

class IssueService
{
    private IssueRepositoryInterface $issueRepo;

    public function __construct(IssueRepositoryInterface $issueRepo)
    {
        $this->issueRepo = $issueRepo;
    }

    /**
     * @param string $name
     * @param string|null $description
     * @param array $fields
     * @param int $projectId
     * @param int|null $userId
     * @return Issue
     * @throws ProjectToAddIssueNotExistsException
     * @throws UserToAssigneeIssueNotExistsException
     */
    public function addIssue(string $name, ?string $description, array $fields, int $projectId, ?int $userId): Issue
    {
        $this->assertProjectExists($projectId);

        if ($userId !== null)
        {
            $this->assertUserExists($userId);
        }

        $issue = new Issue(
            null,
            $name,
            $description,
            $fields,
            $projectId,
            $userId,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $this->issueRepo->add($issue);

        return $issue;
    }

    /**
     * @param int $projectId
     * @throws ProjectToAddIssueNotExistsException
     */
    private function assertProjectExists(int $projectId): void
    {
        if (false)
        {
            throw new ProjectToAddIssueNotExistsException('Project not exists', ['project_id' => $projectId]);
        }
    }

    /**
     * @param int $userId
     * @throws UserToAssigneeIssueNotExistsException
     */
    private function assertUserExists(int $userId): void
    {
        if (false)
        {
            throw new UserToAssigneeIssueNotExistsException('User not exists', ['user_id' => $userId]);
        }
    }
}