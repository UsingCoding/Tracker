<?php

namespace App\Module\Issue\Domain\Adapter;

use App\Module\Project\Domain\Model\Project;
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

         // To add project reference to issue table need project entity

         return $project;

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