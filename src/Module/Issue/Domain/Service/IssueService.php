<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Utils\Arrays;
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
        $project = $this->assertProjectExists($projectId);
        $user = null;

        if ($userId !== null)
        {
            $user = $this->assertUserExists($userId);
        }

        $issue = new Issue(
            null,
            $name,
            $description,
            $fields,
            $project,
            $user,
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
     * @param int|null $newUserId
     * @param int|null $newProjectId
     * @param array|null $newFields
     * @throws IssueByIdNotFoundException|UserToAssigneeIssueNotExistsException|ProjectToAddIssueNotExistsException
     */
    public function editIssue(
        int $issueId, 
        ?string $newName, 
        ?string $newDescription,
        ?int $newUserId,
        ?int $newProjectId,
        ?array $newFields
    ): void
    {
        $issue = $this->issueRepo->findById($issueId);

        $updated = false;

        if ($issue === null)
        {
            throw new IssueByIdNotFoundException('issue not found', ['issue_id' => $issueId]);
        }

        if ($newName !== null && $newName !== $issue->getName())
        {
            $issue->setName($newName);
            $updated = true;
        }


        if ($newDescription !== null && $issue->getDescription() !== $newDescription)
        {
            $issue->setDescription($newDescription);
            $updated = true;
        }

        if ($newUserId !== null && $issue->getUserId() !== $newUserId)
        {
            $user = $this->assertUserExists($newUserId);
            $issue->setUserId($user);
            $updated = true;
        }

        if ($newProjectId !== null && $issue->getProjectId() !== $newProjectId)
        {
            $project = $this->assertProjectExists($newProjectId);
            $issue->setProjectId($project);
            $updated = true;
        }

        if ($newFields !== null && $newFields !== $issue->getFields())
        {
            $issue->setFields(Arrays::merge($issue->getFields(), $newFields));
            $updated = true;
        }

        if ($updated)
        {
            $issue->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    /**
     * @param int $projectId
     * @throws ProjectToAddIssueNotExistsException
     * @return mixed
     */
    private function assertProjectExists(int $projectId)
    {
        $project = $this->projectAdapter->getProjectById($projectId);

        if ($project === null)
        {
            throw new ProjectToAddIssueNotExistsException('Project not exists', ['project_id' => $projectId]);
        }

        return $project;
    }

    /**
     * @param int $userId
     * @throws UserToAssigneeIssueNotExistsException
     * @return mixed
     */
    private function assertUserExists(int $userId)
    {
        $user = $this->userAdapter->getUserById($userId);

        if ($user === null)
        {
            throw new UserToAssigneeIssueNotExistsException('User not exists', ['user_id' => $userId]);
        }

        return $user;
    }
}