<?php

namespace App\Module\Project\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Strings;
use App\Module\Project\App\Command\CreateProjectCommand;
use App\Module\Project\Domain\Service\ProjectDataSanitizer;
use App\Module\Project\Domain\Service\ProjectService;

class CreateProjectCommandHandler implements AppCommandHandlerInterface
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
        if (!$command instanceof CreateProjectCommand)
        {
            throw new InvalidCommandException('Invalid command provided for handle', ['expected_command' => CreateProjectCommand::class]);
        }

        $name = ProjectDataSanitizer::sanitizeName($command->getPayload()[CreateProjectCommand::NAME]);
        $nameId = ProjectDataSanitizer::sanitizeNameId($command->getPayload()[CreateProjectCommand::NAME_ID]);
        $ownerId = $command->getPayload()[CreateProjectCommand::OWNER_ID];
        $description = ProjectDataSanitizer::sanitizeDescription($command->getPayload()[CreateProjectCommand::DESCRIPTION]);


        $this->synchronization->transaction(fn() => $this->projectService->addProject($name, $nameId !== null ? Strings::upper($nameId) : null, $ownerId, $description));
    }
}