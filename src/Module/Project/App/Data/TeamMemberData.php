<?php

namespace App\Module\Project\App\Data;

class TeamMemberData
{
    private int $id;
    private int $userId;
    private string $username;

    public function __construct(int $id, int $userId, string $username)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
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
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}