<?php

namespace App\Module\Project\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Module\Project\App\Command\CreateProjectCommand;
use App\Module\Project\Domain\Service\ProjectDataSanitizer;
use App\Module\Project\Domain\Service\ProjectService;
use Psr\Log\LoggerInterface;

class CreateProjectCommandHandler implements AppCommandHandlerInterface
{
    private ProjectService $projectService;
    private SynchronizationInterface $synchronization;
    private LoggerInterface $logger;

    public function __construct(ProjectService $projectService, SynchronizationInterface $synchronization, LoggerInterface $logger)
    {
        $this->projectService = $projectService;
        $this->synchronization = $synchronization;
        $this->logger = $logger;
    }


    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof CreateProjectCommand)
        {
            throw new InvalidCommandException('Invalid command provided for handle', ['expected_command' => CreateProjectCommand::class]);
        }

        $this->logger->debug('Command executed');

        $name = ProjectDataSanitizer::sanitizeName($command->getPayload()[CreateProjectCommand::NAME]);
        $nameId = ProjectDataSanitizer::sanitizeNameId($command->getPayload()[CreateProjectCommand::NAME_ID]);
        $description = ProjectDataSanitizer::sanitizeDescription($command->getPayload()[CreateProjectCommand::DESCRIPTION]);

        $this->synchronization->transaction(fn() => $this->projectService->addProject($name, $nameId, $description));
    }
}