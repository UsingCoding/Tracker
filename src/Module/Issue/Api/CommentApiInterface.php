<?php

namespace App\Module\Issue\Api;

use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddCommentInput;

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
}