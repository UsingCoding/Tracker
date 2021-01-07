<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Exception\ModelCorruptedException;
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
    private const FIELD_DEFAULT_VALUE = 'null';

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
        $user = null;

        if ($userId !== null)
        {
            $this->assertUserExists($userId);
        }

        $nextInProjectId = $this->issueRepo->getNextInProjectId($projectId);

        $issue = new Issue(
            null,
            $nextInProjectId,
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

        if ($newUserId === null)
        {
            $issue->setUserId(null);
            $updated = true;
        }
        elseif ($issue->getUserId() !== $newUserId)
        {
            $this->assertUserExists($newUserId);
            $issue->setUserId($newUserId);
            $updated = true;
        }

        if ($newProjectId !== null && $issue->getProjectId() !== $newProjectId)
        {
            $this->assertProjectExists($newProjectId);
            $newInProjectId = $this->issueRepo->getNextInProjectId($newProjectId);
            $issue->setInProjectId($newInProjectId);
            $issue->setProjectId($newProjectId);
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
     * @param int $issueId
     * @throws IssueByIdNotFoundException
     */
    public function deleteIssue(int $issueId): void
    {
        $issue = $this->issueRepo->findById($issueId);

        if ($issue === null)
        {
            throw new IssueByIdNotFoundException('', ['issue_id' => $issueId]);
        }

        $this->issueRepo->remove($issue);
    }

    public function addFieldToIssues(int $fieldId, int $projectId): void
    {
        $issues = $this->issueRepo->findForProject($projectId);

        foreach ($issues as $issue)
        {
            $fields = $issue->getFields();

            $fields = Arrays::merge($fields, [$fieldId => self::FIELD_DEFAULT_VALUE]);

            $issue->setFields($fields);
        }
    }

    /**
     * @param int $fieldId
     * @param int $projectId
     * @throws ModelCorruptedException
     */
    public function editFieldInIssues(int $fieldId, int $projectId): void
    {
        $issues = $this->issueRepo->findForProject($projectId);

        foreach ($issues as $issue)
        {
            $fields = $issue->getFields();

            if (!Arrays::hasKey($fields, $fieldId))
            {
                throw new ModelCorruptedException('Issue Field name not found is issue fields', [
                    'issue_id' => $issue->getId(),
                    'issue_field_id' => $fieldId
                ]);
            }

            $fields[$fieldId] = self::FIELD_DEFAULT_VALUE;

            $issue->setFields($fields);
        }
    }

    public function deleteFieldFromIssues(int $fieldId, int $projectId): void
    {
        $issues =  $this->issueRepo->findForProject($projectId);

        foreach ($issues as $issue)
        {
            $fields = $issue->getFields();

            Arrays::removeByKey($fields, $fieldId);

            $issue->setFields($fields);
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