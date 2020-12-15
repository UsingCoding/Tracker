<?php

namespace App\Module\User\App\Data;

interface EditUserRequestInterface
{
    public function getUserId(): int;
    public function getEmail(): ?string;
    public function getUsername(): ?string;
    public function getPassword(): ?string;
    public function getGrade(): ?int;
}