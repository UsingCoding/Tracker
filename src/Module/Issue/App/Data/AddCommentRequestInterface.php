<?php

namespace App\Module\Issue\App\Data;

interface AddCommentRequestInterface
{
    public function getIssueId(): int;
    public function getUserId(): int;
    public function getContent(): string;
}