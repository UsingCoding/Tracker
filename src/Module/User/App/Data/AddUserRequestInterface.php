<?php

namespace App\Module\User\App\Data;

interface AddUserRequestInterface
{
    public function getEmail(): string;
    public function getUsername(): string;
    public function getPassword(): string;
    public function getGrade(): int;
}