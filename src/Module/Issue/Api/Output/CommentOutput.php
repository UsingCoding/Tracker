<?php

namespace App\Module\Issue\Api\Output;

class CommentOutput
{
    private int $id;
    private string $username;
    private string $content;

    public function __construct(int $id, string $username, string $content)
    {
        $this->id = $id;
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