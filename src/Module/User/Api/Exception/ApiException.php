<?php


namespace App\Module\User\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;
use App\Module\User\App\Exception\IncorrectUserPasswordException;
use App\Module\User\App\Exception\UserNotFoundException;

class ApiException extends AbstractApiException
{
    public const USER_NOT_FOUND = 1;
    public const INCORRECT_PASSWORD = 2;

    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): array
    {
        return [
            UserNotFoundException::class => self::USER_NOT_FOUND,
            IncorrectUserPasswordException::class => self::INCORRECT_PASSWORD
        ];
    }
}