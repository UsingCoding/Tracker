<?php


namespace App\Module\Project\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Mapper\ProjectMapper;
use App\Module\Project\Api\Output\GetProjectOutput;
use App\Module\Project\App\Command\CreateProjectCommand;
use App\Module\Project\App\Query\ProjectQueryService;

class Api implements ApiInterface
{
    private ProjectQueryService $projectQueryService;
    private AppCommandBusInterface $projectCommandBus;

    public function __construct(ProjectQueryService $projectQueryService, AppCommandBusInterface $projectCommandBus)
    {
        $this->projectQueryService = $projectQueryService;
        $this->projectCommandBus = $projectCommandBus;
    }

    public function createProject(CreateProjectInput $input): void
    {
        $command = new CreateProjectCommand($input);

        $this->publish($command);
    }

    public function getProject(int $id): GetProjectOutput
    {
        try
        {
            return ProjectMapper::getProjectOutput($this->projectQueryService->getProjectData($id));
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