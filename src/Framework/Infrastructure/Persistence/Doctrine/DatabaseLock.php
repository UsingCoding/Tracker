<?php

namespace App\Framework\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DatabaseLock
{
    private string $id;
    private Connection $connection;
    private int $timeOut;

    public function __construct(string $id, Connection $connection, int $timeOut = 5)
    {
        $this->id = $id;
        $this->connection = $connection;
        $this->timeOut = $timeOut;
    }


    /**
     * @throws Exception
     */
    public function acquire(): void
    {
        $this->acquireImpl(self::makeShortLockId($this->id));
    }

    /**
     * @throws Exception
     */
    public function release(): void
    {
        $this->releaseImpl(self::makeShortLockId($this->id));
    }

    /**
     * @param string $id
     * @throws Exception
     */
    private function acquireImpl(string $id): void
    {
        $this->executeQuery(
            'SELECT GET_LOCK(CONCAT(DATABASE(), \'.\', :id), :timeout)',
            [
                'id' => $id,
                'timeout' => $this->timeOut
            ],
            "lock $id"
        );
    }

    /**
     * @param string $id
     * @throws Exception
     */
    private function releaseImpl(string $id): void
    {
        $this->executeQuery(
            'SELECT RELEASE_LOCK(CONCAT(DATABASE(), \'.\', :id))',
            [
                'id' => $id
            ],
            "unlock $id"
        );
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $error
     * @throws Exception
     */
    private function executeQuery(string $sql, array $params, string $error): void
    {
        $res = $this->connection->executeQuery($sql, $params)->fetchColumn();

        if ($res !== '1')
        {
            throw new \RuntimeException($error);
        }
    }

    private static function makeShortLockId(string $id): string
    {
        return md5($id);
    }
}