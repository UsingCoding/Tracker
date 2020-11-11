<?php

namespace App\Module\Project\Domain\Service;

use App\Module\Project\Domain\Model\Project;
use App\Module\Project\Domain\Model\ProjectRepositoryInterface;

class ProjectService
{
    private ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getProject(int $id): ?Project
    {
        return $this->projectRepository->findById($id);
    }
}