<?php


namespace App\Module\Account\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;
use App\Module\Account\App\Query\Exception\AccountNotFoundException;

class ApiException extends AbstractApiException
{
    public const ACCOUNT_NOT_FOUND = 1;

    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): ?array
    {
        return [
            AccountNotFoundException::class => self::ACCOUNT_NOT_FOUND
        ];
    }
}