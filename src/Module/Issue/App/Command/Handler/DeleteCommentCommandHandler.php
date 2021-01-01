<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Command\DeleteCommentCommand;
use App\Module\Issue\Domain\Service\CommentService;

class DeleteCommentCommandHandler implements AppCommandHandlerInterface
{
    private SynchronizationInterface $synchronization;
    private CommentService $service;

    public function __construct(SynchronizationInterface $synchronization, CommentService $service)
    {
        $this->synchronization = $synchronization;
        $this->service = $service;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof DeleteCommentCommand)
        {
            throw new InvalidCommandException('Unexpected command', ['expected_command' => DeleteCommentCommand::class]);
        }

        $payload = $command->getPayload();

        $commentId = Arrays::get($payload, DeleteCommentCommand::COMMENT_ID);

        $this->synchronization->transaction(fn() => $this->service->deleteComment($commentId));
    }
}