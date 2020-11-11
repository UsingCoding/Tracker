<?php


namespace App\Module\Project\Api;


use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\Project\Api\Mapper\ProjectMapper;
use App\Module\Project\Api\Output\GetProjectOutput;
use App\Module\Project\App\Query\ProjectQueryService;

class Api implements ApiInterface
{
    private ProjectQueryService $projectQueryService;

    public function __construct(ProjectQueryService $projectQueryService)
    {
        $this->projectQueryService = $projectQueryService;
    }

    public function createProject(CreateProjectInput $input): void
    {
        // TODO: Implement createProject() method.
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
}