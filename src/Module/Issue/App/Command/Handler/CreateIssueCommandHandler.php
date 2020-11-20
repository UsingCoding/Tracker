<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Module\Issue\App\Command\CreateIssueCommand;
use App\Module\Issue\Domain\Service\IssueDataSanitizer;
use App\Module\Issue\Domain\Service\IssueService;

class CreateIssueCommandHandler implements AppCommandHandlerInterface
{
    private IssueService $issueService;
    private SynchronizationInterface $synchronization;

    public function __construct(IssueService $issueService, SynchronizationInterface $synchronization)
    {
        $this->issueService = $issueService;
        $this->synchronization = $synchronization;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof CreateIssueCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => CreateIssueCommand::class]);
        }

        $fields = $command->getValue(CreateIssueCommand::FIELDS);
        $name = IssueDataSanitizer::sanitizeName($command->getValue(CreateIssueCommand::NAME));
        $description = IssueDataSanitizer::sanitizeDescription($command->getValue(CreateIssueCommand::DESCRIPTION));
        $projectId = IssueDataSanitizer::sanitizeProjectId($fields);
        $userId = IssueDataSanitizer::sanitizeUserId($fields);

        $this->synchronization->transaction(fn() => $this->issueService->addIssue($name, $description, $fields, $projectId, $userId));
    }
}