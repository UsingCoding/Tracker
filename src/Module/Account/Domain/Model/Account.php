<?php

namespace App\Module\Account\Domain\Model;

class Account
{
    private int $id;
    private string $domainName;
    private bool $isActive;
    private \DateTimeImmutable $createdAt;
    private string $dbName;

    public function __construct(int $id, string $domainName, bool $isActive, \DateTimeImmutable $createdAt, string $dbName)
    {
        $this->id = $id;
        $this->domainName = $domainName;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
        $this->dbName = $dbName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domainName;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }
}