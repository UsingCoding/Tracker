<?php


namespace App\Module\Project\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\AddTeamMemberInput;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Input\EditProjectInput;
use App\Module\Project\Api\Mapper\ProjectMapper;
use App\Module\Project\Api\Mapper\TeamMemberMapper;
use App\Module\Project\Api\Output\ProjectOutput;
use App\Module\Project\Api\Output\ProjectsListOutput;
use App\Module\Project\Api\Output\TeamMemberListOutput;
use App\Module\Project\App\Command\AddTeamMemberCommand;
use App\Module\Project\App\Command\CreateProjectCommand;
use App\Module\Project\App\Command\DeleteProjectCommand;
use App\Module\Project\App\Command\EditProjectCommand;
use App\Module\Project\App\Command\RemoveTeamMemberCommand;
use App\Module\Project\App\Query\ProjectQueryService;
use App\Module\Project\App\Query\ProjectQueryServiceInterface;
use App\Module\Project\App\Query\TeamMemberQueryServiceInterface;

class Api implements ApiInterface
{
    private ProjectQueryService $projectQueryServiceRepo;
    private ProjectQueryServiceInterface $projectQueryService;
    private TeamMemberQueryServiceInterface $teamMemberQueryService;
    private AppCommandBusInterface $projectCommandBus;

    public function __construct(ProjectQueryService $projectQueryServiceRepo, ProjectQueryServiceInterface $projectQueryService, AppCommandBusInterface $projectCommandBus, TeamMemberQueryServiceInterface $teamMemberQueryService)
    {
        $this->projectQueryServiceRepo = $projectQueryServiceRepo;
        $this->projectQueryService = $projectQueryService;
        $this->projectCommandBus = $projectCommandBus;
        $this->teamMemberQueryService = $teamMemberQueryService;
    }

    public function createProject(CreateProjectInput $input): void
    {
        $command = new CreateProjectCommand($input);

        $this->publish($command);
    }

    public function getProject(int $id): ProjectOutput
    {
        try
        {
            return ProjectMapper::getProjectOutput($this->projectQueryServiceRepo->getProjectData($id));
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function projectsListForUser(int $userId): ProjectsListOutput
    {
        try
        {
            $projects = $this->projectQueryService->listForUser($userId);

            return ProjectMapper::getProjectListOutput($projects);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function editProject(EditProjectInput $input): void
    {
        $command = new EditProjectCommand($input);

        $this->publish($command);
    }

    public function deleteProject(int $projectId, int $ownerId): void
    {
        $command = new DeleteProjectCommand($projectId, $ownerId);

        $this->publish($command);
    }

    public function addMember(AddTeamMemberInput $input): void
    {
        $command = new AddTeamMemberCommand($input);

        $this->publish($command);
    }

    public function removeMember(int $teamMemberId): void
    {
        $command = new RemoveTeamMemberCommand($teamMemberId);

        $this->publish($command);
    }

    public function teamMemberList(int $projectId): TeamMemberListOutput
    {
        try
        {
            $list = $this->teamMemberQueryService->getList($projectId);

            return TeamMemberMapper::getList($list);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    /**
     * @param CommandInterface $command
     * @throws ApiException
     */
    private function publish(CommandInterface $command): void
    {
        try
        {
            $this->projectCommandBus->publish($command);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}