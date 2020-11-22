<?php

namespace App\Module\Issue\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Common\App\Event\AppEventHandlerInterface;
use App\Common\App\Event\AppEventInterface;
use App\Common\App\Event\AppEventSourceInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\CreateIssueInput;
use App\Module\Issue\Api\Input\EditIssueInput;
use App\Module\Issue\Api\Mapper\IssueOutputMapper;
use App\Module\Issue\Api\Output\GetIssueOutput;
use App\Module\Issue\App\Command\CreateIssueCommand;
use App\Module\Issue\App\Command\EditIssueCommand;
use App\Module\Issue\App\Event\IssueAddedEvent;
use App\Module\Issue\App\Query\IssueQueryServiceInterface;

class Api implements ApiInterface
{
    private AppCommandBusInterface $issueCommandBus;
    private IssueQueryServiceInterface $issueQueryService;
    private AppEventSourceInterface $eventSource;

    public function __construct(
        AppCommandBusInterface $issueCommandBus,
        IssueQueryServiceInterface $issueQueryService,
        AppEventSourceInterface $eventSource
    )
    {
        $this->issueCommandBus = $issueCommandBus;
        $this->issueQueryService = $issueQueryService;
        $this->eventSource = $eventSource;
    }

    public function createIssue(CreateIssueInput $input): int
    {
        $command = new CreateIssueCommand($input);

        return $this->publishCommandWithAddIssueEventHandler($command);
    }

    public function getIssue(string $code): ?GetIssueOutput
    {
        try
        {
            $issueData = $this->issueQueryService->getIssue($code);

            if ($issueData === null)
            {
                return null;
            }

            return IssueOutputMapper::getIssueOutput($issueData);
        }
        catch (\Throwable $e)
        {
            throw ApiException::from($e);
        }
    }

    public function editIssue(EditIssueInput $input): void
    {
        $command = new EditIssueCommand($input);

        $this->publish($command);
    }

    /**
     * @param CommandInterface $command
     * @return int
     * @throws ApiException
     */
    private function publishCommandWithAddIssueEventHandler(CommandInterface $command): int
    {
        $handler = new class implements AppEventHandlerInterface {
            private int $issueId;

            public function handle(AppEventInterface $event): void
            {
                if ($event instanceof IssueAddedEvent)
                {
                    $this->issueId = $event->getIssueId();
                }
            }

            public function getIssueId(): int
            {
                return $this->issueId;
            }
        };

        $this->eventSource->subscribe($handler);

        try
        {
            $this->publish($command);
        }
        finally
        {
            $this->eventSource->unsubscribe($handler);
        }

        return $handler->getIssueId();
    }

    /**
     * @param CommandInterface $command
     * @throws ApiException
     */
    private function publish(CommandInterface $command): void
    {
        try
        {
            $this->issueCommandBus->publish($command);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}