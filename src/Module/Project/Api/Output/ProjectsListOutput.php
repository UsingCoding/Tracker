<?php

namespace App\Module\Project\Api\Output;

class ProjectsListOutput
{
    /** @var ProjectOutput[] */
    private array $projects;

    public function __construct(array $projects)
    {
        $this->projects = $projects;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }
}