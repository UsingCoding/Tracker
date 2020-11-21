<?php

namespace App\Module\Issue\Domain\Service;

use App\Module\Issue\Domain\Adapter\ProjectAdapterInterface;
use App\Module\Issue\Domain\Adapter\UserAdapterInterface;
use App\Module\Issue\Domain\Exception\IssueByIdNotFoundException;
use App\Module\Issue\Domain\Exception\ProjectToAddIssueNotExistsException;
use App\Module\Issue\Domain\Exception\UserToAssigneeIssueNotExistsException;
use App\Module\Issue\Domain\Model\Issue;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;

class IssueService
{
    private IssueRepositoryInterface $issueRepo;
    private ProjectAdapterInterface $projectAdapter;
    private UserAdapterInterface $userAdapter;

    public function __construct(
        IssueRepositoryInterface $issueRepo,
        ProjectAdapterInterface $projectAdapter,
        UserAdapterInterface $userAdapter
    )
    {
        $this->issueRepo = $issueRepo;
        $this->projectAdapter = $projectAdapter;
        $this->userAdapter = $userAdapter;
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
     * @param int $issueId
     * @param string|null $newName
     * @param string|null $newDescription
     * @throws IssueByIdNotFoundException
     */
    public function editIssue(int $issueId, ?string $newName, ?string $newDescription): void
    {
        $issue = $this->issueRepo->findById($issueId);

        if ($issue === null)
        {
            throw new IssueByIdNotFoundException('issue not found', ['issue_id' => $issueId]);
        }

        if ($newName !== null && $newName !== $issue->getName())
        {
            $issue->setName($newName);
        }
        else
        {
            $newName = null;
        }

        if ($newDescription !== null && $issue->getDescription() !== $newDescription)
        {
            $issue->setDescription($newDescription);
        }
        else
        {
            $newDescription = null;
        }

        if ($newName !== null || $newDescription !== null)
        {
            $issue->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    /**
     * @param int $projectId
     * @throws ProjectToAddIssueNotExistsException
     */
    private function assertProjectExists(int $projectId): void
    {
        $project = $this->projectAdapter->getProjectById($projectId);

        if ($project === null)
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
        $user = $this->userAdapter->getUserById($userId);

        if ($user === null)
        {
            throw new UserToAssigneeIssueNotExistsException('User not exists', ['user_id' => $userId]);
        }
    }
}