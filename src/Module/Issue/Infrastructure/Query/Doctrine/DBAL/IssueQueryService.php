<?php

namespace App\Module\Issue\Infrastructure\Query\Doctrine\DBAL;

use App\Module\Issue\App\Query\Data\IssueData;
use App\Module\Issue\App\Query\IssueQueryServiceInterface;
use App\Module\Issue\Domain\Service\IssueCodeService;
use App\Module\Issue\Infrastructure\Hydration\IssueDataHydrator;
use App\Module\Issue\Infrastructure\Hydration\IssueListWithUserAndProjectDataHydrator;
use App\Module\Issue\Infrastructure\Hydration\IssueWithFieldsHydrator;
use App\Module\Issue\Infrastructure\Query\SearchQueryParser;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;

class IssueQueryService implements IssueQueryServiceInterface
{
    private Connection $connection;
    private SearchQueryParser $queryParser;

    public function __construct(Connection $connection, SearchQueryParser $queryParser)
    {
        $this->connection = $connection;
        $this->queryParser = $queryParser;
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

    public function list(string $query): array
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
        ;

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
}
