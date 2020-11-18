<?php

namespace App\Module\Issue\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;

class ApiException extends AbstractApiException
{
    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): ?array
    {
        return null;
    }
}