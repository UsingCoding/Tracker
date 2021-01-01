<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Event\AppEventDispatcherInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Command\AddCommentCommand;
use App\Module\Issue\App\Event\CommentAddedEvent;
use App\Module\Issue\Domain\Model\Comment;
use App\Module\Issue\Domain\Service\CommentService;

class AddCommentCommandHandler implements AppCommandHandlerInterface
{
    private SynchronizationInterface $synchronization;
    private CommentService $service;
    private AppEventDispatcherInterface $eventDispatcher;

    public function __construct(
        SynchronizationInterface $synchronization,
        CommentService $service,
        AppEventDispatcherInterface $eventDispatcher
    )
    {
        $this->synchronization = $synchronization;
        $this->service = $service;
        $this->eventDispatcher = $eventDispatcher;
    }


    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof AddCommentCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => AddCommentCommand::class]);
        }

        $payload = $command->getPayload();

        $issueId = Arrays::get($payload, AddCommentCommand::ISSUE_ID);
        $userId = Arrays::get($payload, AddCommentCommand::USER_ID);
        $content = Arrays::get($payload, AddCommentCommand::CONTENT);

        /** @var Comment $comment */
        $comment = $this->synchronization->transaction(fn() => $this->service->addComment($issueId, $userId, $content));

        $this->eventDispatcher->dispatch(new CommentAddedEvent($comment->getId()));
    }
}