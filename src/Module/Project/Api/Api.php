<?php


namespace App\Module\Project\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Input\EditProjectInput;
use App\Module\Project\Api\Mapper\ProjectMapper;
use App\Module\Project\Api\Output\ProjectOutput;
use App\Module\Project\Api\Output\ProjectsListOutput;
use App\Module\Project\App\Command\CreateProjectCommand;
use App\Module\Project\App\Command\EditProjectCommand;
use App\Module\Project\App\Query\ProjectQueryService;
use App\Module\Project\App\Query\ProjectQueryServiceInterface;

class Api implements ApiInterface
{
    private ProjectQueryService $projectQueryServiceRepo;
    private ProjectQueryServiceInterface $projectQueryService;
    private AppCommandBusInterface $projectCommandBus;

    public function __construct(ProjectQueryService $projectQueryServiceRepo, ProjectQueryServiceInterface $projectQueryService, AppCommandBusInterface $projectCommandBus)
    {
        $this->projectQueryServiceRepo = $projectQueryServiceRepo;
        $this->projectQueryService = $projectQueryService;
        $this->projectCommandBus = $projectCommandBus;
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

    public function projectsList(): ProjectsListOutput
    {
        try
        {
            $projects = $this->projectQueryService->list();

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