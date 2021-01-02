<?php

namespace App\Module\Issue\App\Data;

interface EditCommentRequestInterface
{
    public function getCommentId(): int;
    public function getContent(): string;
}