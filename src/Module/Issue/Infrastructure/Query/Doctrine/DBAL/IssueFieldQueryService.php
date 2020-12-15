<?php

namespace App\Module\Issue\Infrastructure\Query\Doctrine\DBAL;

use App\Module\Issue\App\Query\IssueFieldQueryServiceInterface;
use App\Module\Issue\Infrastructure\Hydration\IssueFieldListDataHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;

class IssueFieldQueryService implements IssueFieldQueryServiceInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function listForProject(int $projectId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('if.issue_id')
            ->addSelect('if.name')
            ->addSelect('if.type')
            ->from('issue_field', 'if')
            ->where($queryBuilder->expr()->eq('if.project_id', ':project_id'))
            ->setParameter('project_id', $projectId, ParameterType::INTEGER)
        ;

        $stmt = $queryBuilder->execute();
        $row = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($row === false)
        {
            return [];
        }

        $hydrator = new IssueFieldListDataHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($row);
    }
}