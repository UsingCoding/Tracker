<?php

namespace App\Module\Account\Api\Output;

class AccountOutput
{
    private int $id;
    private int $ownerId;
    private \DateTimeImmutable $createdAt;

    public function __construct(int $id, int $ownerId, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}