<?php

namespace App\Module\Project\Domain\Service;

use App\Module\Project\App\Exception\ProjectByIdNotFoundException;
use App\Module\Project\Domain\Adapter\UserAdapterInterface;
use App\Module\Project\Domain\Exception\TeamMemberByIdNotFoundException;
use App\Module\Project\Domain\Exception\UserAlreadyInTeamException;
use App\Module\Project\Domain\Exception\UserToAddToTeamByIdNotFoundException;
use App\Module\Project\Domain\Model\ProjectRepositoryInterface;
use App\Module\Project\Domain\Model\TeamMember;
use App\Module\Project\Domain\Model\TeamMemberRepositoryInterface;

class TeamMemberService
{
    private TeamMemberRepositoryInterface $teamMemberRepository;
    private ProjectRepositoryInterface $projectRepository;
    private UserAdapterInterface $userAdapter;

    public function __construct(
        TeamMemberRepositoryInterface $teamMemberRepository,
        ProjectRepositoryInterface $projectRepository,
        UserAdapterInterface $userAdapter
    )
    {
        $this->teamMemberRepository = $teamMemberRepository;
        $this->projectRepository = $projectRepository;
        $this->userAdapter = $userAdapter;
    }

    /**
     * @param int $projectId
     * @param int $userId
     * @throws ProjectByIdNotFoundException
     * @throws UserToAddToTeamByIdNotFoundException
     * @throws UserAlreadyInTeamException
     */
    public function addMember(int $projectId, int $userId): void
    {
        if ($this->hasMember($projectId, $userId))
        {
            throw new UserAlreadyInTeamException('', ['project_id' => $projectId, 'user_id' => $userId]);
        }

        $this->assertProjectExists($projectId);
        $this->assertUserExists($userId);

        $teamMember = new TeamMember(
            null,
            $projectId,
            $userId
        );

        $this->teamMemberRepository->add($teamMember);
    }

    /**
     * @param int $memberId
     * @throws TeamMemberByIdNotFoundException
     */
    public function removeMember(int $memberId): void
    {
        $teamMember = $this->teamMemberRepository->findById($memberId);

        if ($teamMember === null)
        {
            throw new TeamMemberByIdNotFoundException('', ['member_id' => $memberId]);
        }

        $this->teamMemberRepository->remove($teamMember);
    }

    public function hasMember(int $projectId, int $userId): bool
    {
        return $this->teamMemberRepository->findMemberForProject($projectId, $userId) !== null;
    }

    /**
     * @param int $projectId
     * @throws ProjectByIdNotFoundException
     */
    private function assertProjectExists(int $projectId): void
    {
        if ($this->projectRepository->findById($projectId) === null)
        {
            throw new ProjectByIdNotFoundException('', ['project_id' => $projectId]);
        }
    }

    /**
     * @param int $userId
     * @throws UserToAddToTeamByIdNotFoundException
     */
    private function assertUserExists(int $userId): void
    {
        if ($this->userAdapter->getUserById($userId) === null)
        {
            throw new UserToAddToTeamByIdNotFoundException('', ['user_id' => $userId]);
        }
    }
}