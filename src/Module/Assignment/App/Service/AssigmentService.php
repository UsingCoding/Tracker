<?php

namespace App\Module\Assignment\App\Service;

use App\Common\Domain\Utils\Arrays;
use App\Module\Assignment\App\Adapter\IssueAdapterInterface;
use App\Module\Assignment\App\Adapter\IssueFieldTypeAdapter;
use App\Module\Assignment\App\Data\IssueField;
use App\Module\Assignment\App\Exception\FailedToGetIssueFieldsListException;

class AssigmentService
{
    private const ESTIMATION_FIELD_NAME = 'estimation';
    private const DIFFICULTY_FIELD_NAME = 'difficulty';

    private const FIELD_NAME_TYPE_MAP = [
        self::ESTIMATION_FIELD_NAME => IssueFieldTypeAdapter::TIME_INTERVAL,
        self::DIFFICULTY_FIELD_NAME => IssueFieldTypeAdapter::STRING
    ];

    private IssueAdapterInterface $issueAdapter;

    public function __construct(IssueAdapterInterface $issueAdapter)
    {
        $this->issueAdapter = $issueAdapter;
    }

    /**
     * @param int $projectId
     * @return bool
     * @throws FailedToGetIssueFieldsListException
     */
    public function isAutoAssigmentAvailable(int $projectId): bool
    {
        $fieldsList = $this->issueAdapter->getFields($projectId);

        return $this->fieldsListSatisfyRequirements($fieldsList);
    }

    /**
     * @param IssueField[] $fieldsList
     * @return bool
     */
    private function fieldsListSatisfyRequirements(array $fieldsList): bool
    {
        $searchIndicator = 0;

        foreach ($fieldsList as $field)
        {
            if (($expectedType = Arrays::get(self::FIELD_NAME_TYPE_MAP, $field->getName())) !== null && $expectedType === $field->getType())
            {
                ++$searchIndicator;
            }
        }

        return $searchIndicator === Arrays::length(self::FIELD_NAME_TYPE_MAP);
    }
}