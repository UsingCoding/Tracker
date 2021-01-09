<?php

namespace App\Module\Issue\Api;

use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddCommentInput;
use App\Module\Issue\Api\Input\EditCommentInput;
use App\Module\Issue\Api\Output\CommentOutput;

interface CommentApiInterface
{
    /**
     * @param AddCommentInput $input
     * @return int
     * @throws ApiException
     */
    public function addComment(AddCommentInput $input): int;

    /**
     * @param int $commentId
     * @throws ApiException
     */
    public function deleteComment(int $commentId): void;

    /**
     * @param EditCommentInput $input
     * @throws ApiException
     */
    public function editComment(EditCommentInput $input): void;

    /**
     * @param int $issueId
     * @return CommentOutput[]
     * @throws ApiException
     */
    public function commentsForIssue(int $issueId): array;
}