<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Command\DeleteIssueCommand;
use App\Module\Issue\Domain\Service\IssueService;

class DeleteIssueCommandHandler implements AppCommandHandlerInterface
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
        if (!$command instanceof DeleteIssueCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => DeleteIssueCommand::class]);
        }

        $issueId = Arrays::get($command->getPayload(), DeleteIssueCommand::ISSUE_ID);

        $this->synchronization->transaction(fn() => $this->issueService->deleteIssue($issueId));
    }
}