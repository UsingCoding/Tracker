<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Event\AppEventDispatcherInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Command\AddIssueFieldCommand;
use App\Module\Issue\App\Event\IssueFieldAddedEvent;
use App\Module\Issue\Domain\Model\IssueField;
use App\Module\Issue\Domain\Service\IssueFieldDataSanitizer;
use App\Module\Issue\Domain\Service\IssueFieldService;

class AddIssueFieldCommandHandler implements AppCommandHandlerInterface
{
    private IssueFieldService $issueFieldService;
    private SynchronizationInterface $synchronization;
    private AppEventDispatcherInterface $eventDispatcher;

    public function __construct(
        IssueFieldService $issueFieldService,
        SynchronizationInterface $synchronization,
        AppEventDispatcherInterface $eventDispatcher
    )
    {
        $this->issueFieldService = $issueFieldService;
        $this->synchronization = $synchronization;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof AddIssueFieldCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => AddIssueFieldCommand::class]);
        }

        $payload = $command->getPayload();

        $name = IssueFieldDataSanitizer::sanitizeName(Arrays::get($payload, AddIssueFieldCommand::NAME));
        $type = Arrays::get($payload, AddIssueFieldCommand::FIELD_TYPE);
        $projectId = Arrays::get($payload, AddIssueFieldCommand::PROJECT_ID);

        /** @var IssueField $issueField */
        $issueField = $this->synchronization->transaction(fn() => $this->issueFieldService->addField($name, $type, $projectId));

        $this->eventDispatcher->dispatch(new IssueFieldAddedEvent($issueField->getId()));
    }
}