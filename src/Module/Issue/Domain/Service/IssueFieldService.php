<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Event\DomainEventDispatcherInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Domain\Adapter\ProjectAdapterInterface;
use App\Module\Issue\Domain\Event\IssueFieldAdded;
use App\Module\Issue\Domain\Event\IssueFieldDeleted;
use App\Module\Issue\Domain\Event\IssueFieldEdited;
use App\Module\Issue\Domain\Exception\InvalidIssueFieldTypeException;
use App\Module\Issue\Domain\Exception\IssueFieldByIdNotFoundException;
use App\Module\Issue\Domain\Exception\IssueNameBusyException;
use App\Module\Issue\Domain\Exception\ProjectToAddFieldNotExistsException;
use App\Module\Issue\Domain\Model\IssueField;
use App\Module\Issue\Domain\Model\IssueFieldRepositoryInterface;
use App\Module\Issue\Domain\Model\IssueFieldType;
use Exception;

class IssueFieldService
{
    private IssueFieldRepositoryInterface $issueFieldRepository;
    private ProjectAdapterInterface $projectAdapter;
    private DomainEventDispatcherInterface $eventDispatcher;

    public function __construct(
        IssueFieldRepositoryInterface $issueFieldRepository,
        ProjectAdapterInterface $projectAdapter,
        DomainEventDispatcherInterface $eventDispatcher
    )
    {
        $this->issueFieldRepository = $issueFieldRepository;
        $this->projectAdapter = $projectAdapter;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $name
     * @param int $type
     * @param int $projectId
     * @return IssueField
     * @throws InvalidIssueFieldTypeException
     * @throws ProjectToAddFieldNotExistsException
     * @throws IssueNameBusyException
     * @throws Exception
     */
    public function addField(string $name, int $type, int $projectId): IssueField
    {
        $this->assertProjectExists($projectId);
        $this->assertIssueFieldTypeExists($type);
        $this->assertIssueFieldIsNotBusy($name, $projectId);

        $issueField = new IssueField(
            null,
            $name,
            $type,
            $projectId
        );

        $this->issueFieldRepository->add($issueField);

        $this->eventDispatcher->dispatch(new IssueFieldAdded(
            $issueField->getId(),
            $issueField->getName(),
            $issueField->getType(),
            $issueField->getProjectId()
        ));

        return $issueField;
    }

    /**
     * @param int $issueFieldId
     * @param string|null $newName
     * @param int|null $newType
     * @throws InvalidIssueFieldTypeException
     * @throws IssueFieldByIdNotFoundException
     * @throws IssueNameBusyException
     * @throws Exception
     */
    public function editIssueField(int $issueFieldId, ?string $newName, ?int $newType): void
    {
        if ($newType !== null)
        {
            $this->assertIssueFieldTypeExists($newType);
        }

        $issueField = $this->issueFieldRepository->findById($issueFieldId);

        if ($issueField === null)
        {
            throw new IssueFieldByIdNotFoundException('Issue field not found', ['issue_field_id' => $issueFieldId]);
        }

        if ($newName !== null && $newName !== $issueField->getName())
        {
            $this->assertIssueFieldIsNotBusy($newName, $issueField->getProjectId());

            $issueField->setName($newName);
        }

        if ($newType !== null && $newType !== $issueField->getType())
        {
            $issueField->setType($newType);
        }

        $this->eventDispatcher->dispatch(new IssueFieldEdited(
            $issueFieldId,
            $newName,
            $newType,
            $issueField->getProjectId()
        ));
    }

    /**
     * @param int $issueFieldId
     * @throws IssueFieldByIdNotFoundException
     * @throws Exception
     */
    public function deleteIssueField(int $issueFieldId): void
    {
        $issueField = $this->issueFieldRepository->findById($issueFieldId);

        if ($issueField === null)
        {
            throw new IssueFieldByIdNotFoundException('Issue field not found', ['issue_field_id' => $issueFieldId]);
        }

        $this->issueFieldRepository->remove($issueField);

        $this->eventDispatcher->dispatch(new IssueFieldDeleted(
            $issueFieldId,
            $issueField->getProjectId(),
            $issueField->getName()
        ));
    }

    public function validateIssueFields(int $projectId, array $newFields): void
    {
        $issueFields = $this->issueFieldRepository->findForProject($projectId);

        foreach ($newFields as $field)
        {

        }
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

    /**
     * @param string $name
     * @param int $projectId
     * @throws IssueNameBusyException
     */
    private function assertIssueFieldIsNotBusy(string $name, int $projectId): void
    {
        $issueField = $this->issueFieldRepository->findByNameInProject($name, $projectId);

        if ($issueField !== null)
        {
            throw new IssueNameBusyException('', ['name' => $name, 'projectId' => $projectId]);
        }
    }
}