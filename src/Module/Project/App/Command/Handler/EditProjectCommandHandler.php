<?php

namespace App\Module\Project\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Project\App\Command\EditProjectCommand;
use App\Module\Project\Domain\Service\ProjectDataSanitizer;
use App\Module\Project\Domain\Service\ProjectService;

class EditProjectCommandHandler implements AppCommandHandlerInterface
{
    private SynchronizationInterface $synchronization;
    private ProjectService $projectService;

    public function __construct(SynchronizationInterface $synchronization, ProjectService $projectService)
    {
        $this->synchronization = $synchronization;
        $this->projectService = $projectService;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof EditProjectCommand)
        {
            throw new InvalidCommandException('Invalid command provided for handle', ['expected_command' => EditProjectCommand::class]);
        }

        $payload = $command->getPayload();

        $rawName = Arrays::get($payload, EditProjectCommand::NAME);
        $name = $rawName !== null ? ProjectDataSanitizer::sanitizeName($rawName) : null;

        $rawDescription = Arrays::get($payload, EditProjectCommand::DESCRIPTION);
        $description = $rawDescription !== null ? ProjectDataSanitizer::sanitizeDescription($rawDescription) : null;

        $this->synchronization->transaction(fn() => $this->projectService->editProject(
            Arrays::get($payload, EditProjectCommand::PROJECT_ID),
            Arrays::get($payload, EditProjectCommand::OWNER_ID),
            Arrays::get($payload, EditProjectCommand::NEW_OWNER_ID),
            $name,
            $description
        ));
    }
}