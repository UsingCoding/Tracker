<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Module\Issue\App\Command\CreateIssueCommand;
use App\Module\Issue\Domain\Service\IssueDataSanitizer;
use App\Module\Issue\Domain\Service\IssueService;

class CreateIssueCommandHandler implements AppCommandHandlerInterface
{
    private IssueService $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }


    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof CreateIssueCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => CreateIssueCommand::class]);
        }

        $name = IssueDataSanitizer::sanitizeName($command->getValue(CreateIssueCommand::NAME));
        $description = IssueDataSanitizer::sanitizeDescription($command->getValue(CreateIssueCommand::DESCRIPTION));
        $projectId = IssueDataSanitizer::sanitizeProjectId($command->getValue(CreateIssueCommand::FIELDS));
        $userId = IssueDataSanitizer::sanitizeUserId($command->getValue(CreateIssueCommand::FIELDS));
        $fields = $command->getValue(CreateIssueCommand::FIELDS);

        $this->issueService->addIssue($name, $description, $fields, $projectId, $userId);
    }
}