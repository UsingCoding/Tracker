<?php

namespace App\Module\Issue\Domain\Model;

interface IssueRepositoryInterface
{
    public function add(Issue $issue): void;

    public function getNextInProjectId(int $projectId): int;

    public function findById(int $id): ?Issue;

    /**
     * @param int $projectId
     * @return Issue[]
     */
    public function findForProject(int $projectId): array;

    public function remove(Issue $issue): void;
}