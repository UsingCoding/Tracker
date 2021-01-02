<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Utils\Strings;
use App\Module\Issue\Domain\Exception\InvalidCommentDataException;

class CommentDataSanitizer
{
    private const CONTENT_MAX_LENGTH = 1000;

    /**
     * @param string $rawContent
     * @return string
     * @throws InvalidCommentDataException
     */
    public static function sanitizeContent(string $rawContent): string
    {
        $content = Strings::trim($rawContent);

        $contentLength = Strings::length($content);

        $contentMaxLength = self::CONTENT_MAX_LENGTH;
        if ($content === 0 || $contentLength > $contentMaxLength)
        {
            throw new InvalidCommentDataException("Description must have length from 1 to {$contentLength}");
        }

        return $content;
    }
}