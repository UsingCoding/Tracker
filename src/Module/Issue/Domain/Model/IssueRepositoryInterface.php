<?php

namespace App\Module\Issue\Domain\Model;

interface IssueRepositoryInterface
{
    public function add(Issue $issue): void;

    public function getNextInProjectId(int $projectId): int;

    public function findById(int $id): ?Issue;

    public function remove(Issue $issue): void;
}