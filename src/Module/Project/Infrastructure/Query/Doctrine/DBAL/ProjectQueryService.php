<?php

namespace App\Module\Project\Infrastructure\Query\Doctrine\DBAL;

use App\Module\Project\App\Query\ProjectQueryServiceInterface;
use App\Module\Project\Infrastructure\Hydration\ProjectListDataHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class ProjectQueryService implements ProjectQueryServiceInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function listForUser(int $userId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('p.project_id')
            ->addSelect('p.name')
            ->addSelect('p.name_id')
            ->addSelect('p.owner_id')
            ->addSelect('p.description')
            ->from('project', 'p')
            ->leftJoin('p', 'team_member', 'tm', 'p.project_id = tm.project_id')
            ->where($queryBuilder->expr()->eq('tm.user_id', ':user_id'))
            ->setParameter('user_id', $userId)
        ;

        $stmt = $queryBuilder->execute();
        $row = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($row === false)
        {
            return [];
        }

        $hydrator = new ProjectListDataHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($row);
    }
}