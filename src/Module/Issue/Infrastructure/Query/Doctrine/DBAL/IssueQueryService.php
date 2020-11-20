<?php

namespace App\Module\Issue\Infrastructure\Query\Doctrine\DBAL;

use App\Module\Issue\App\Data\IssueData;
use App\Module\Issue\App\Query\IssueQueryServiceInterface;
use App\Module\Issue\Domain\Service\IssueCodeService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;
use Psr\Log\LoggerInterface;

class IssueQueryService implements IssueQueryServiceInterface
{
    private Connection $connection;
    private LoggerInterface $logger;

    public function __construct(Connection $connection, \Psr\Log\LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function getIssue(string $code): ?IssueData
    {
        $issueCode = IssueCodeService::splitCode($code);

        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('i.name')
            ->addSelect('i.description')
            ->addSelect('i.fields')
            ->from('issue', 'i')
            ->leftJoin('i', 'project', 'p', 'p.name_id = :project_name_id')
            ->andWhere($queryBuilder->expr()->eq('issue_id', ':issue_id'))
            ->setParameter('issue_id', $issueCode->getIssueId(), ParameterType::INTEGER)
            ->setParameter('project_name_id', $issueCode->getProjectNameId(), ParameterType::STRING)
        ;

        $stmt = $queryBuilder->execute();
        $row = $stmt->fetch(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($row === false)
        {
            $this->logger->debug("NOTHING FETCHED");
            return null;
        }

        $this->logger->debug("DATA", $row);

        return new IssueData();
    }
}