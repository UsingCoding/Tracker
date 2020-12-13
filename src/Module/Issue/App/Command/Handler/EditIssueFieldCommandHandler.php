<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Module\Issue\App\Command\EditIssueFieldCommand;
use App\Module\Issue\Domain\Service\IssueFieldDataSanitizer;
use App\Module\Issue\Domain\Service\IssueFieldService;

class EditIssueFieldCommandHandler implements AppCommandHandlerInterface
{
    private IssueFieldService $issueFieldService;
    private SynchronizationInterface $synchronization;

    public function __construct(IssueFieldService $issueFieldService, SynchronizationInterface $synchronization)
    {
        $this->issueFieldService = $issueFieldService;
        $this->synchronization = $synchronization;
    }


    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof EditIssueFieldCommand)
        {
            throw new InvalidCommandException('', ['expected_command' => EditIssueFieldCommand::class]);
        }

        $issueFieldId = $command->getValue(EditIssueFieldCommand::ISSUE_FIELD_ID);
        $newName = $command->getValue(EditIssueFieldCommand::NAME) !== null ? IssueFieldDataSanitizer::sanitizeName($command->getValue(EditIssueFieldCommand::NAME)) : null;
        $newType = $command->getValue(EditIssueFieldCommand::FIELD_TYPE);

        $this->synchronization->transaction(fn() => $this->issueFieldService->editIssueField($issueFieldId, $newName, $newType));
    }
}