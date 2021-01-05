<?php

namespace App\Module\Issue\App\Query\Data;

class CommentData
{
    private int $id;
    private int $userId;
    private string $username;
    private string $content;

    public function __construct(int $id, int $userId, string $username, string $content)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
        $this->content = $content;
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

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}