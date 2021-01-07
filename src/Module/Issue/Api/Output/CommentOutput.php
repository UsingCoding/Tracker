<?php

namespace App\Module\Issue\Api\Output;

class CommentOutput
{
    private int $id;
    private string $username;
    private ?string $userAvatarUrl;
    private string $content;

    public function __construct(int $id, string $username, ?string $userAvatarUrl, string $content)
    {
        $this->id = $id;
        $this->username = $username;
        $this->userAvatarUrl = $userAvatarUrl;
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
     * @return string|null
     */
    public function getUserAvatarUrl(): ?string
    {
        return $this->userAvatarUrl;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}