<?php

namespace App\Module\Issue\App\Query;

use App\Module\Issue\App\Query\Data\CommentData;
use Exception;

interface CommentQueryServiceInterface
{
    /**
     * @param int $issueId
     * @return CommentData[]
     * @throws Exception
     */
    public function getCommentsForIssue(int $issueId): array;
}