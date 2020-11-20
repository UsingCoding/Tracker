<?php

namespace App\Module\Issue\Domain\Adapter;

use App\Module\Issue\Domain\Model\Project;
use App\Module\Project\Domain\Model\ProjectRepositoryInterface;

class ProjectAdapter implements ProjectAdapterInterface
{
    private ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getProjectById(int $projectId): ?Project
    {
         $project = $this->projectRepository->findById($projectId);

         if ($project === null)
         {
             return null;
         }

         return new Project(
             $project->getId(),
             $project->getName(),
             $project->getNameId(),
             $project->getDescription()
         );
    }
}