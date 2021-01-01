<?php

namespace App\Module\Issue\Domain\Model;

interface CommentRepositoryInterface
{
    public function add(Comment $comment): void;

    public function findById(int $id): ?Comment;

    public function remove(Comment $comment): void;
}