<?php

namespace App\Module\Issue\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Command\EditCommentCommand;
use App\Module\Issue\Domain\Service\CommentDataSanitizer;
use App\Module\Issue\Domain\Service\CommentService;

class EditCommentCommandHandler implements AppCommandHandlerInterface
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
        if (!$command instanceof EditCommentCommand)
        {
            throw new InvalidCommandException('', ['expected_command' => EditCommentCommand::class]);
        }

        $payload = $command->getPayload();

        $commentId = Arrays::get($payload, EditCommentCommand::COMMENT_ID);
        $content = CommentDataSanitizer::sanitizeContent(Arrays::get($payload, EditCommentCommand::CONTENT));

        $this->synchronization->transaction(fn() => $this->service->editComment($commentId, $content));
    }
}