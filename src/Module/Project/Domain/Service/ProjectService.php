<?php

namespace App\Module\Project\Domain\Service;

use App\Module\Project\App\Exception\ProjectByIdNotFoundException;
use App\Module\Project\Domain\Adapter\UserAdapterInterface;
use App\Module\Project\Domain\Exception\DuplicateProjectNameIdException;
use App\Module\Project\Domain\Exception\InvalidOwnerToDeleteProjectException;
use App\Module\Project\Domain\Exception\InvalidOwnerToEditProjectException;
use App\Module\Project\Domain\Exception\UserNotExistsException;
use App\Module\Project\Domain\Exception\UserToAddToTeamByIdNotFoundException;
use App\Module\Project\Domain\Model\Project;
use App\Module\Project\Domain\Model\ProjectRepositoryInterface;

class ProjectService
{
    private ProjectRepositoryInterface $projectRepository;
    private TeamMemberService $teamMemberService;
    private UserAdapterInterface $userAdapter;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        UserAdapterInterface $userAdapter,
        TeamMemberService $teamMemberService
    )
    {
        $this->projectRepository = $projectRepository;
        $this->userAdapter = $userAdapter;
        $this->teamMemberService = $teamMemberService;
    }

    public function getProject(int $id): ?Project
    {
        return $this->projectRepository->findById($id);
    }

    /**
     * @param string $name
     * @param string $nameId
     * @param int $ownerId
     * @param string|null $description
     * @return Project
     * @throws DuplicateProjectNameIdException
     * @throws ProjectByIdNotFoundException
     * @throws UserNotExistsException
     * @throws UserToAddToTeamByIdNotFoundException
     */
    public function addProject(string $name, string $nameId, int $ownerId, ?string $description): Project
    {
        $this->assertNoDuplicateNameId($nameId);
        $this->assertUserExists($ownerId);

        $project = new Project(null, $name, $nameId, $ownerId, $description);
        $this->projectRepository->add($project);

        $this->teamMemberService->addMember($project->getId(), $ownerId);

        return $project;
    }

    /**
     * @param int $projectId
     * @param int $ownerId
     * @param string|null $newName
     * @param string|null $newDescription
     * @throws ProjectByIdNotFoundException
     * @throws InvalidOwnerToEditProjectException
     */
    public function editProject(int $projectId, int $ownerId, ?string $newName, ?string $newDescription): void
    {
        $project = $this->projectRepository->findById($projectId);

        if ($project === null)
        {
            throw new ProjectByIdNotFoundException('', ['project_id' => $projectId]);
        }

        if ($project->getOwnerId() !== $ownerId)
        {
            throw new InvalidOwnerToEditProjectException('', [
                'project_id' => $projectId,
                'owner_id' => $ownerId,
                'actual_owner_id' => $project->getOwnerId()
            ]);
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
     * @param int $projectId
     * @param int $ownerId
     * @throws ProjectByIdNotFoundException
     * @throws InvalidOwnerToDeleteProjectException
     */
    public function deleteProject(int $projectId, int $ownerId): void
    {
        $project = $this->projectRepository->findById($projectId);

        if ($project === null)
        {
            throw new ProjectByIdNotFoundException('', ['project_id' => $projectId]);
        }

        if ($project->getOwnerId() !== $ownerId)
        {
            throw new InvalidOwnerToDeleteProjectException('', [
                'project_id' => $projectId,
                'owner_id' => $ownerId,
                'actual_owner_id' => $project->getOwnerId()
            ]);
        }

        $this->projectRepository->remove($project);
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

    /**
     * @param int $userId
     * @throws UserNotExistsException
     */
    private function assertUserExists(int $userId): void
    {
        if ($this->userAdapter->getUserById($userId) === null)
        {
            throw new UserNotExistsException('', ['user_id']);
        }
    }
}