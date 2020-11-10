<?php

namespace App\Module\User\Domain\Model;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findByUsername(string $username): ?User;

    public function remove(User $user): void;
}