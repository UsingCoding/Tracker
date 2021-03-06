<?php

namespace App\Module\Issue\Infrastructure\Query\Doctrine\DBAL;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Query\Data\IssueData;
use App\Module\Issue\App\Query\IssueQueryServiceInterface;
use App\Module\Issue\Domain\Service\IssueCodeService;
use App\Module\Issue\Infrastructure\Hydration\IssueDataHydrator;
use App\Module\Issue\Infrastructure\Hydration\IssueListWithUserAndProjectDataHydrator;
use App\Module\Issue\Infrastructure\Hydration\IssueWithFieldsHydrator;
use App\Module\Issue\Infrastructure\Query\SearchQueryBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;

class IssueQueryService implements IssueQueryServiceInterface
{
    private const ISSUES_ON_PAGE = 20;

    private Connection $connection;
    private SearchQueryBuilder $searchQueryBuilder;

    public function __construct(Connection $connection, SearchQueryBuilder $searchQueryBuilder)
    {
        $this->connection = $connection;
        $this->searchQueryBuilder = $searchQueryBuilder;
    }

    public function getIssue(string $code): ?IssueData
    {
        $issueCode = IssueCodeService::splitCode($code);

        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('i.issue_id')
            ->addSelect('i.name issue_name')
            ->addSelect('i.description')
            ->addSelect('i.fields')
            ->addSelect('i.created_at')
            ->addSelect('i.updated_at')
            ->addSelect('i.in_project_id')
            ->addSelect('p.name project_name')
            ->addSelect('p.project_id')
            ->addSelect('ac.user_id')
            ->addSelect('ac.username')
            ->from('issue', 'i')
            ->leftJoin('i', 'project', 'p', 'p.name_id = :project_name_id')
            ->leftJoin('i', 'account_user', 'ac', 'ac.user_id = i.user_id')
            ->andWhere($queryBuilder->expr()->eq('in_project_id', ':in_project_id'))
            ->andWhere($queryBuilder->expr()->eq('i.project_id', 'p.project_id'))
            ->setParameter('in_project_id', $issueCode->getIssueInProjectId(), ParameterType::INTEGER)
            ->setParameter('project_name_id', $issueCode->getProjectNameId(), ParameterType::STRING)
        ;

        $stmt = $queryBuilder->execute();
        $row = $stmt->fetch(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($row === false)
        {
            return null;
        }

        $hydrator = new IssueDataHydrator($this->connection->getDatabasePlatform());

        /** @var IssueData[] $results */
        $results = [];

        $hydrator->hydrate($row, $results);
        return $results[0];
    }

    public function issuesList(string $query, int $page = 1, ?int $currentUserId = null, ?int $projectId = null): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            // Due to the doctrine bug, all fields were written manually
            ->addSelect('i.issue_id')
            ->addSelect('i.name')
            ->addSelect('i.description')
            ->addSelect('i.fields')
            ->addSelect('i.updated_at')
            ->addSelect('i.in_project_id')
            ->addSelect('p.name_id')
            ->addSelect('ac.username')
            ->from('issue', 'i')
            ->leftJoin('i', 'account_user', 'ac', 'ac.user_id = i.user_id')
            ->leftJoin('i', 'project', 'p', 'p.project_id = i.project_id')
            ->setFirstResult(self::ISSUES_ON_PAGE * ($page - 1))
            ->setMaxResults(self::ISSUES_ON_PAGE)
        ;

        if ($currentUserId !== null)
        {
            $queryBuilder
                ->leftJoin('p', 'team_member', 'tm', 'p.project_id = tm.project_id and ac.user_id = tm.user_id')
                ->where($queryBuilder->expr()->eq('tm.user_id', ':current_user_id'))
                ->setParameter('current_user_id', $currentUserId, ParameterType::INTEGER)
            ;
        }

        $this->searchQueryBuilder->build($query, $queryBuilder);

        if ($projectId !== null)
        {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('i.project_id', ':project_id'))
                ->setParameter('project_id', $projectId, ParameterType::INTEGER)
            ;
        }

        $stmt = $queryBuilder->execute();
        $row = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($row === false)
        {
            return [];
        }

        $hydrator = new IssueListWithUserAndProjectDataHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($row);
    }

    public function getIssueForProject(int $projectId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('i.issue_id')
            ->addSelect('i.fields')
            ->addSelect('i.project_id')
            ->from('issue', 'i')
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

        $hydrator = new IssueWithFieldsHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($rows);
    }

    public function getIssuesIdAllowedForUserTeamMember(int $userId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('i.issue_id')
            ->from('issue', 'i')
            ->leftJoin('i', 'project', 'p', 'p.project_id = i.project_id')
            ->leftJoin('p', 'team_member', 'tm', 'p.project_id = tm.project_id and tm.user_id = :current_user_id')
            ->setParameter('current_user_id', $userId, ParameterType::INTEGER)
        ;

        $stmt = $queryBuilder->execute();
        $rows = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($rows === false)
        {
            return [];
        }

        return (array) Arrays::map($rows, static fn($row) => $row['issue_id']);
    }
}
