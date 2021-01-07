<?php

namespace App\Module\Issue\Infrastructure\Query\Doctrine\DBAL;

use App\Module\Issue\App\Query\CommentQueryServiceInterface;
use App\Module\Issue\Infrastructure\Hydration\CommentDataHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class CommentQueryService implements CommentQueryServiceInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getCommentsForIssue(int $issueId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('c.comment_id')
            ->addSelect('c.user_id')
            ->addSelect('ac.username')
            ->addSelect('ac.avatar_url')
            ->addSelect('c.content')
            ->from('comment', 'c')
            ->leftJoin('c', 'account_user', 'ac', 'ac.user_id = c.user_id')
            ->where($queryBuilder->expr()->eq('c.issue_id', ':issue_id'))
            ->setParameter('issue_id', $issueId);

        $stmt = $queryBuilder->execute();
        $row = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($row === false)
        {
            return [];
        }

        $hydrator = new CommentDataHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($row);
    }
}