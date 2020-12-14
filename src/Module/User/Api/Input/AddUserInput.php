<?php

namespace App\Module\User\Api\Input;

use App\Module\User\App\Data\AddUserRequestInterface;

class AddUserInput implements AddUserRequestInterface
{
    private string $email;
    private string $username;
    private string $password;
    private int $grade;

    public function __construct(string $email, string $username, string $password, int $grade)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->grade = $grade;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
     * @return int
     */
    public function getGrade(): int
    {
        return $this->grade;
    }
}