<?php

namespace App\Module\Project\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Project\App\Data\ProjectListItemData;

class ProjectListDataHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new ProjectListItemData(
            $this->convertValue(ProjectListDataMapping::PROJECT_ID, $row),
            $this->convertValue(ProjectListDataMapping::NAME, $row),
            $this->convertValue(ProjectListDataMapping::NAME_ID, $row),
            $this->convertValue(ProjectListDataMapping::DESCRIPTION, $row),
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return ProjectListDataMapping::getColumnTypeName($columnName);
    }
}