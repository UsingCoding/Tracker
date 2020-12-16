<?php

namespace App\Module\User\Api\Input;

use App\Module\User\App\Data\EditUserRequestInterface;

class EditUserInput implements EditUserRequestInterface
{
    private int $userId;
    private ?string $email;
    private ?string $username;
    private ?string $password;
    private ?int $grade;

    public function __construct(int $userId, ?string $email, ?string $username, ?string $password, ?int $grade)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->grade = $grade;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return int|null
     */
    public function getGrade(): ?int
    {
        return $this->grade;
    }
}