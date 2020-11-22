<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Command\EditIssueCommand;
use App\Module\Issue\Domain\Service\IssueDataSanitizer;
use App\Module\Issue\Domain\Service\IssueService;

class EditIssueCommandHandler implements AppCommandHandlerInterface
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
        if (!$command instanceof EditIssueCommand)
        {
            throw new InvalidCommandException('', ['expected_command' => EditIssueCommand::class]);
        }

        $issueId = $command->getValue(EditIssueCommand::ISSUE_ID);
        $rawName = $command->getValue(EditIssueCommand::NAME);
        $newName = $rawName !== null ? IssueDataSanitizer::sanitizeName($rawName) : null;
        $newDescription = IssueDataSanitizer::sanitizeDescription($command->getValue(EditIssueCommand::DESCRIPTION));

        $newFields = $command->getValue(EditIssueCommand::FIELDS);

        $newUserId = IssueDataSanitizer::sanitizeUserId($newFields);
        $newProjectId = Arrays::get($newFields, IssueDataSanitizer::PROJECT_ID_KEY) === null ? null : IssueDataSanitizer::sanitizeProjectId($newFields);

        $this->synchronization->transaction(fn() => $this->issueService->editIssue(
            $issueId,
            $newName,
            $newDescription,
            $newUserId,
            $newProjectId,
            $newFields
        ));
    }
}