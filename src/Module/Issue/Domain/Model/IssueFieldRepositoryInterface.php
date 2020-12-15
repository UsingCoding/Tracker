<?php

namespace App\Module\Issue\Domain\Model;

interface IssueFieldRepositoryInterface
{
    public function add(IssueField $issue): void;

    public function findById(int $id): ?IssueField;

    public function findByNameInProject(string $name, int $projectId): ?IssueField;

    public function remove(IssueField $issue): void;

    /***
     * @param int $projectId
     * @return IssueField[]
     */
    public function findForProject(int $projectId): array;
}