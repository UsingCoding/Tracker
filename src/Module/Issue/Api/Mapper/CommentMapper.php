<?php

namespace App\Module\Issue\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\CommentOutput;
use App\Module\Issue\App\Query\Data\CommentData;

class CommentMapper
{
    /**
     * @param CommentData[] $comments
     * @return CommentOutput[]
     */
    public static function getComments(array $comments): array
    {
        return (array) Arrays::map(
            $comments,
            static fn(CommentData $data) => self::getComment($data)
        );
    }

    public static function getComment(CommentData $commentData): CommentOutput
    {
        return new CommentOutput(
            $commentData->getId(),
            $commentData->getUsername(),
            $commentData->getUserAvatarUrl(),
            $commentData->getContent(),
            $commentData->getCreatedAt(),
            $commentData->getUpdatedAt(),
        );
    }
}