<?php

namespace App\Module\User\App\Data;

class UserData
{
    private int $id;
    private string $username;
    private string $password;
    private \DateTimeImmutable $createdAt;
    private string $email;
    private int $grade;
    private ?string $avatarUrl;

    public function __construct(int $id, string $username, string $password, \DateTimeImmutable $createdAt, string $email, int $grade, ?string $avatarUrl)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->email = $email;
        $this->grade = $grade;
        $this->avatarUrl = $avatarUrl;
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
    public function getPassword(): string
    {
        return $this->password;
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
    public function getEmail(): string
    {
        return $this->email;
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