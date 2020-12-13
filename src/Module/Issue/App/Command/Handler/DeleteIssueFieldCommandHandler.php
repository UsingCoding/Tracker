<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Command\DeleteIssueFieldCommand;
use App\Module\Issue\Domain\Service\IssueFieldService;

class DeleteIssueFieldCommandHandler implements AppCommandHandlerInterface
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
        if (!$command instanceof DeleteIssueFieldCommand)
        {
            throw new InvalidCommandException('', ['expected_command' => DeleteIssueFieldCommand::class]);
        }

        $payload = $command->getPayload();

        $this->synchronization->transaction(fn() =>
            $this->issueFieldService->deleteIssueField(Arrays::get($payload, DeleteIssueFieldCommand::ISSUE_FIELD_ID))
        );
    }
}