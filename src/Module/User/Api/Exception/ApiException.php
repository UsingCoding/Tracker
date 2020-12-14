<?php


namespace App\Module\User\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;
use App\Module\User\App\Exception\IncorrectUserPasswordException;
use App\Module\User\App\Exception\UserNotFoundException;
use App\Module\User\Domain\Exception\DuplicateUserEmailException;
use App\Module\User\Domain\Exception\DuplicateUsernameException;
use App\Module\User\Domain\Exception\UnknownUserGradeException;

class ApiException extends AbstractApiException
{
    public const USER_NOT_FOUND = 1;
    public const INCORRECT_PASSWORD = 2;

    public const DUPLICATE_EMAIL = 3;
    public const DUPLICATE_USERNAME = 4;
    public const UNKNOWN_GRADE = 5;

    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): array
    {
        return [
            UserNotFoundException::class => self::USER_NOT_FOUND,
            IncorrectUserPasswordException::class => self::INCORRECT_PASSWORD,
            DuplicateUserEmailException::class => self::DUPLICATE_EMAIL,
            DuplicateUsernameException::class => self::DUPLICATE_USERNAME,
            UnknownUserGradeException::class => self::UNKNOWN_GRADE
        ];
    }
}