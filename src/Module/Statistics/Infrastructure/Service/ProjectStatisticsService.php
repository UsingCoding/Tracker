<?php

namespace App\Module\Statistics\Infrastructure\Service;

use App\Module\Statistics\App\Data\ProjectStatisticsData;
use App\Module\Statistics\App\Service\ProjectStatisticsServiceInterface;
use App\Module\Statistics\Infrastructure\Hydration\UserToIssuesCountHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;

class ProjectStatisticsService implements ProjectStatisticsServiceInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getProjectStatistics(int $projectId): ProjectStatisticsData
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $stmt = $queryBuilder
            ->addSelect('count(*) issues_count')
            ->addSelect('ac.username')
            ->from('issue', 'i')
            ->leftJoin('i', 'account_user', 'ac', 'ac.user_id = i.user_id')
            ->where($queryBuilder->expr()->eq('project_id', ':project_id'))
            ->andWhere($queryBuilder->expr()->isNotNull('i.user_id'))
            ->groupBy('ac.user_id')
            ->setParameter('project_id', $projectId, ParameterType::INTEGER)
            ->execute()
        ;

        $rows = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        $result = [];

        if ($rows !== false)
        {
            $hydrator = new UserToIssuesCountHydrator($this->connection->getDatabasePlatform());

            $result = $hydrator->hydrateAll($rows);
        }

        return new ProjectStatisticsData($result);
    }
}