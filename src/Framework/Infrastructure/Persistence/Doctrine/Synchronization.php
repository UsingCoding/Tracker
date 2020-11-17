<?php

namespace App\Framework\Infrastructure\Persistence\Doctrine;

use App\Common\App\Synchronization\SynchronizationInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class Synchronization implements SynchronizationInterface
{
    private EntityManagerInterface $entityManager;
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager, Connection $connection)
    {
        $this->entityManager = $entityManager;
        $this->connection = $connection;
    }

    public function transaction(callable $job)
    {
        $connection = $this->entityManager->getConnection();
        $connection->beginTransaction();

        try
        {
            $val = $job();
            $this->entityManager->flush();
            $connection->commit();

            return $val;
        }
        catch (\Throwable $exception)
        {
            $connection->rollBack();
            throw $exception;
        }
    }

    public function lockWithTransaction(string $lockName, callable $job)
    {
        $lock = new DatabaseLock($lockName, $this->connection);
        $lock->acquire();

        try
        {
            return $this->transaction($job);
        }
        finally
        {
            $lock->release();
        }
    }
}