<?php

namespace App\Module\Project\Domain\Model;

interface TeamMemberRepositoryInterface
{
    public function add(TeamMember $teamMember): void;

    public function findById(int $id): ?TeamMember;

    public function findMemberForProject(int $projectId, int $userId);

    public function remove(TeamMember $teamMember): void;
}