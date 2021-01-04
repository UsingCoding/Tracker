<?php

namespace App\Module\Issue\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Common\App\Event\AppEventHandlerInterface;
use App\Common\App\Event\AppEventInterface;
use App\Common\App\Event\AppEventSourceInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddCommentInput;
use App\Module\Issue\Api\Input\AddIssueFieldInput;
use App\Module\Issue\Api\Input\CreateIssueInput;
use App\Module\Issue\Api\Input\DeleteIssueFieldInput;
use App\Module\Issue\Api\Input\EditCommentInput;
use App\Module\Issue\Api\Input\EditIssueFieldInput;
use App\Module\Issue\Api\Input\EditIssueInput;
use App\Module\Issue\Api\Mapper\IssueFieldOutputMapper;
use App\Module\Issue\Api\Mapper\IssueOutputMapper;
use App\Module\Issue\Api\Output\GetIssueOutput;
use App\Module\Issue\Api\Output\IssueFieldListOutput;
use App\Module\Issue\Api\Output\IssuesListOutput;
use App\Module\Issue\App\Command\AddCommentCommand;
use App\Module\Issue\App\Command\AddIssueFieldCommand;
use App\Module\Issue\App\Command\CreateIssueCommand;
use App\Module\Issue\App\Command\DeleteCommentCommand;
use App\Module\Issue\App\Command\DeleteIssueCommand;
use App\Module\Issue\App\Command\DeleteIssueFieldCommand;
use App\Module\Issue\App\Command\EditCommentCommand;
use App\Module\Issue\App\Command\EditIssueCommand;
use App\Module\Issue\App\Command\EditIssueFieldCommand;
use App\Module\Issue\App\Event\CommentAddedEvent;
use App\Module\Issue\App\Event\IssueAddedEvent;
use App\Module\Issue\App\Event\IssueFieldAddedEvent;
use App\Module\Issue\App\Query\AppIssueQueryService;
use App\Module\Issue\App\Query\IssueFieldQueryServiceInterface;
use App\Module\Issue\App\Query\IssueQueryServiceInterface;

class Api implements ApiInterface
{
    private AppCommandBusInterface $issueCommandBus;
    private AppIssueQueryService $appIssueQueryService;
    private IssueQueryServiceInterface $issueQueryService;
    private IssueFieldQueryServiceInterface $issueFieldQueryService;
    private AppEventSourceInterface $eventSource;

    public function __construct(AppCommandBusInterface $issueCommandBus, AppIssueQueryService $appIssueQueryService, IssueQueryServiceInterface $issueQueryService, IssueFieldQueryServiceInterface $issueFieldQueryService, AppEventSourceInterface $eventSource)
    {
        $this->issueCommandBus = $issueCommandBus;
        $this->appIssueQueryService = $appIssueQueryService;
        $this->issueQueryService = $issueQueryService;
        $this->issueFieldQueryService = $issueFieldQueryService;
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
            $issueData = $this->appIssueQueryService->getIssue($code);

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

    public function deleteIssue(int $issueId): void
    {
        $command = new DeleteIssueCommand($issueId);

        $this->publish($command);
    }

    public function list(string $query): IssuesListOutput
    {
        try
        {
            $issues = $this->issueQueryService->list($query);

            return IssueOutputMapper::getIssueListOutput($issues);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function addIssueField(AddIssueFieldInput $input): int
    {
        $command = new AddIssueFieldCommand($input);

        return $this->publishCommandWithAddIssueFieldEventHandler($command);
    }

    public function editIssueField(EditIssueFieldInput $input): void
    {
        $command = new EditIssueFieldCommand($input);

        $this->publish($command);
    }

    public function deleteIssueField(DeleteIssueFieldInput $input): void
    {
        $command = new DeleteIssueFieldCommand($input);

        $this->publish($command);
    }

    public function issueFieldListForProject(int $projectId): IssueFieldListOutput
    {
        try
        {
            $list = $this->issueFieldQueryService->listForProject($projectId);

            return IssueFieldOutputMapper::getIssueFieldListOutput($list);
        }
        catch (\Throwable $exception)
        {
            throw ApiException::from($exception);
        }
    }

    public function addComment(AddCommentInput $input): int
    {
        $command = new AddCommentCommand($input);

        return $this->publishCommandWithCommentAddedEventHandler($command);
    }

    public function deleteComment(int $commentId): void
    {
        $command = new DeleteCommentCommand($commentId);

        $this->publish($command);
    }

    public function editComment(EditCommentInput $input): void
    {
        $command = new EditCommentCommand($input);

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
            private int $inProjectId;

            public function handle(AppEventInterface $event): void
            {
                if ($event instanceof IssueAddedEvent)
                {
                    $this->inProjectId = $event->getInProjectId();
                }
            }

            public function getInProjectId(): int
            {
                return $this->inProjectId;
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

        return $handler->getInProjectId();
    }

    /**
     * @param CommandInterface $command
     * @return int
     * @throws ApiException
     */
    private function publishCommandWithCommentAddedEventHandler(CommandInterface $command): int
    {
        $handler = new class implements AppEventHandlerInterface {
            private int $commentId;

            public function handle(AppEventInterface $event): void
            {
                if ($event instanceof CommentAddedEvent)
                {
                    $this->commentId = $event->getCommentId();
                }
            }

            public function getCommentId(): int
            {
                return $this->commentId;
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

        return $handler->getCommentId();
    }

    /**
     * @param CommandInterface $command
     * @return int
     * @throws ApiException
     */
    public function publishCommandWithAddIssueFieldEventHandler(CommandInterface $command): int
    {
        $handler = new class implements AppEventHandlerInterface {
            private int $issueFieldId;

            public function handle(AppEventInterface $event): void
            {
                if ($event instanceof IssueFieldAddedEvent)
                {
                    $this->issueFieldId = $event->getIssueFieldId();
                }
            }

            public function getIssueFieldId(): int
            {
                return $this->issueFieldId;
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

        return $handler->getIssueFieldId();
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