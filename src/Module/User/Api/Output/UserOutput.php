<?php

namespace App\Module\User\Api\Output;

class UserOutput
{
    private int $userId;
    private string $username;
    private string $password;
    private string $email;
    private \DateTimeImmutable $createdAt;
    private int $grade;
    private ?string $avatarUrl;

    public function __construct(int $userId, string $username, string $password, string $email, \DateTimeImmutable $createdAt, int $grade, ?string $avatarUrl)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->grade = $grade;
        $this->avatarUrl = $avatarUrl;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getGrade(): int
    {
        return $this->grade;
    }

    /**
     * @return string|null
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }
}