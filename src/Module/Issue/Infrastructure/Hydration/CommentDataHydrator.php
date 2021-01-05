<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Issue\App\Query\Data\CommentData;
use Doctrine\DBAL\Exception;

class CommentDataHydrator extends AbstractDbalHydrator
{

    /**
     * @param array $row
     * @param array $result
     * @throws Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new CommentData(
            $this->convertValue(CommentDataMapping::COMMENT_ID, $row),
            $this->convertValue(CommentDataMapping::USER_ID, $row),
            $this->convertValue(CommentDataMapping::USERNAME, $row),
            $this->convertValue(CommentDataMapping::CONTENT, $row)
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return CommentDataMapping::getColumnTypeName($columnName);
    }
}