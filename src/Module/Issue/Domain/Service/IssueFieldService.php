<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Domain\Adapter\ProjectAdapterInterface;
use App\Module\Issue\Domain\Exception\InvalidIssueFieldTypeException;
use App\Module\Issue\Domain\Exception\IssueFieldByIdNotFoundException;
use App\Module\Issue\Domain\Exception\ProjectToAddFieldNotExistsException;
use App\Module\Issue\Domain\Model\IssueField;
use App\Module\Issue\Domain\Model\IssueFieldRepositoryInterface;
use App\Module\Issue\Domain\Model\IssueFieldType;

class IssueFieldService
{
    private IssueFieldRepositoryInterface $issueFieldRepository;
    private ProjectAdapterInterface $projectAdapter;

    /**
     * @param int $type
     * @param int $projectId
     * @return IssueField
     * @throws ProjectToAddFieldNotExistsException
     * @throws InvalidIssueFieldTypeException
     */
    public function addField(int $type, int $projectId): IssueField
    {
        $this->assertProjectExists($projectId);
        $this->assertIssueFieldTypeExists($type);

        $issueField = new IssueField(
            null,
            $type,
            $projectId
        );

        $this->issueFieldRepository->add($issueField);

        return $issueField;
    }

    /**
     * @param int $issueFieldId
     * @param int $type
     * @throws InvalidIssueFieldTypeException
     * @throws IssueFieldByIdNotFoundException
     */
    public function editIssueField(int $issueFieldId, int $type): void
    {
        $this->assertIssueFieldTypeExists($type);

        $issueField = $this->issueFieldRepository->findById($issueFieldId);

        if ($issueField === null)
        {
            throw new IssueFieldByIdNotFoundException('Issue field not found', ['issue_field_id' => $issueFieldId]);
        }

        $issueField->setType($type);
    }

    /**
     * @param int $issueFieldId
     * @throws IssueFieldByIdNotFoundException
     */
    public function deleteIssueField(int $issueFieldId): void
    {
        $issueField = $this->issueFieldRepository->findById($issueFieldId);

        if ($issueField === null)
        {
            throw new IssueFieldByIdNotFoundException('Issue field not found', ['issue_field_id' => $issueFieldId]);
        }

        $this->issueFieldRepository->remove($issueField);

        // Dispatch domain event
    }

    /**
     * @param int $projectId
     * @throws ProjectToAddFieldNotExistsException
     */
    private function assertProjectExists(int $projectId): void
    {
        $project = $this->projectAdapter->getProjectById($projectId);

        if ($project === null)
        {
            throw new ProjectToAddFieldNotExistsException('Project not exists', ['project_id' => $projectId]);
        }
    }

    /**
     * @param int $fieldType
     * @throws InvalidIssueFieldTypeException
     */
    private function assertIssueFieldTypeExists(int $fieldType): void
    {
        if (!Arrays::hasValue(IssueFieldType::getTypes(), $fieldType))
        {
            throw new InvalidIssueFieldTypeException('Invalid issue field type provided', ['issue_field_type' => $fieldType]);
        }
    }
}