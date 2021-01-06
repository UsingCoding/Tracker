<?php

namespace App\Module\Project\Infrastructure\Query\Doctrine\DBAL;

use App\Module\Project\App\Query\TeamMemberQueryServiceInterface;
use App\Module\Project\Infrastructure\Hydration\TeamMemberDataHydrator;
use App\Module\Project\Infrastructure\Hydration\UserToAddToTeamHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;

class TeamMemberQueryService implements TeamMemberQueryServiceInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getList(int $projectId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('tm.team_member_id')
            ->addSelect('tm.user_id')
            ->addSelect('ac.username')
            ->from('team_member', 'tm')
            ->leftJoin('tm', 'account_user', 'ac', 'ac.user_id = tm.user_id')
            ->where($queryBuilder->expr()->eq('project_id', ':project_id'))
            ->setParameter('project_id', $projectId, ParameterType::INTEGER)
        ;

        $stmt = $queryBuilder->execute();
        $rows = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($rows === false)
        {
            return [];
        }

        $hydrator = new TeamMemberDataHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($rows);
    }

    public function getUsersToAddTeamList(int $projectId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $stmt = $this->connection->executeQuery(
            $queryBuilder
                ->addSelect('ac.user_id')
                ->addSelect('ac.username')
                ->from('account_user', 'ac')
                ->getSQL()
            . ' except ' .
            $this->connection->createQueryBuilder()
                ->addSelect('ac.user_id')
                ->addSelect('ac.username')
                ->from('account_user', 'ac')
                ->leftJoin('ac', 'team_member', 'tm', 'ac.user_id = tm.user_id')
                ->where($queryBuilder->expr()->eq('project_id', ':project_id'))
                ->getSQL()
            ,
            ['project_id' => $projectId],
            ['project_id' => ParameterType::INTEGER]
        );
        $rows = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($rows === false)
        {
            return [];
        }

        $hydrator = new UserToAddToTeamHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($rows);
    }
}