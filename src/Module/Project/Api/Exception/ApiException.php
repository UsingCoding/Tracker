<?php

namespace App\Module\Project\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;
use App\Module\Project\App\Exception\ProjectByIdNotFoundException;
use App\Module\Project\App\Exception\ProjectNotExistsException;
use App\Module\Project\Domain\Exception\DuplicateProjectNameIdException;

class ApiException extends AbstractApiException
{
    public const PROJECT_NOT_EXISTS = 2;
    public const DUPLICATE_PROJECT_NAME_ID = 3;

    public const PROJECT_BY_ID_NOT_FOUND = 4;

    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): ?array
    {
        return [
            ProjectNotExistsException::class => self::PROJECT_NOT_EXISTS,
            DuplicateProjectNameIdException::class => self::DUPLICATE_PROJECT_NAME_ID,
            ProjectByIdNotFoundException::class => self::PROJECT_BY_ID_NOT_FOUND
        ];
    }
}