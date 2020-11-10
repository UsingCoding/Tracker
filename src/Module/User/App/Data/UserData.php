<?php

namespace App\Module\User\App\Data;

class UserData
{
    private int $id;
    private string $username;
    private string $password;
    private string $createdAt;
    private string $email;

    public function __construct(int $id, string $username, string $password, string $createdAt, string $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->email = $email;
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
     * @return string
     */
    public function getCreatedAt(): string
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
}