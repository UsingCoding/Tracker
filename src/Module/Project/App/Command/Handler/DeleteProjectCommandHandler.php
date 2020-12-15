<?php

namespace App\Module\Project\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Module\Project\App\Command\DeleteProjectCommand;
use App\Module\Project\Domain\Service\ProjectService;

class DeleteProjectCommandHandler implements AppCommandHandlerInterface
{
    private ProjectService $projectService;
    private SynchronizationInterface $synchronization;

    public function __construct(ProjectService $projectService, SynchronizationInterface $synchronization)
    {
        $this->projectService = $projectService;
        $this->synchronization = $synchronization;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof DeleteProjectCommand)
        {
            throw new InvalidCommandException('Invalid command provided for handle', ['expected_command' => DeleteProjectCommand::class]);
        }

        $this->synchronization->transaction(fn() =>
            $this->projectService->deleteProject($command->getPayload()[DeleteProjectCommand::PROJECT_ID])
        );
    }
}