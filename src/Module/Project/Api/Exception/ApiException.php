<?php

namespace App\Module\Project\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;
use App\Module\Project\App\Exception\ProjectNotExistsException;
use App\Module\Project\Domain\Exception\DuplicateProjectNameIdException;

class ApiException extends AbstractApiException
{
    public const PROJECT_NOT_EXISTS = 2;
    public const DUPLICATE_PROJECT_NAME_ID = 3;

    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): ?array
    {
        return [
            self::PROJECT_NOT_EXISTS => ProjectNotExistsException::class,
            self::DUPLICATE_PROJECT_NAME_ID => DuplicateProjectNameIdException::class
        ];
    }
}