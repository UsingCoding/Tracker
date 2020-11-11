<?php

namespace App\Module\Project\Domain\Model;

interface ProjectRepositoryInterface
{
    public function add(Project $project): void;

    public function findById(int $id): ?Project;

    public function findByNameId(string $nameId): ?Project;

    public function remove(Project $project): void;
}