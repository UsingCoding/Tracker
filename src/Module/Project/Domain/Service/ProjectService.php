<?php

namespace App\Module\Project\Domain\Service;

use App\Module\Project\App\Exception\ProjectByIdNotFoundException;
use App\Module\Project\Domain\Exception\DuplicateProjectNameIdException;
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

    /**
     * @param string $name
     * @param string $nameId
     * @param string|null $description
     * @return Project
     * @throws DuplicateProjectNameIdException
     */
    public function addProject(string $name, string $nameId, ?string $description): Project
    {
        $this->assertNoDuplicateNameId($nameId);

        $project = new Project(null, $name, $nameId, $description);
        $this->projectRepository->add($project);

        return $project;
    }

    /**
     * @param int $projectId
     * @param string|null $newName
     * @param string|null $newDescription
     * @throws ProjectByIdNotFoundException
     */
    public function editProject(int $projectId, ?string $newName, ?string $newDescription): void
    {
        $project = $this->projectRepository->findById($projectId);

        if ($project === null)
        {
            throw new ProjectByIdNotFoundException('', ['project_id' => $projectId]);
        }

        if ($newName !== null && $newName !== $project->getName())
        {
            $project->setName($newName);
        }

        if ($newDescription !== null && $newDescription !== $project->getDescription())
        {
            $project->setDescription($newDescription);
        }
    }

    /**
     * @param string $nameId
     * @throws DuplicateProjectNameIdException
     */
    private function assertNoDuplicateNameId(string $nameId): void
    {
        if ($this->projectRepository->findByNameId($nameId) !== null)
        {
            throw new DuplicateProjectNameIdException('Duplicate project nameId', ['nameId' => $nameId]);
        }
    }
}