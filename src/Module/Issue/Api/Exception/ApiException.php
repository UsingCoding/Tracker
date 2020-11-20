<?php

namespace App\Module\Issue\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;
use App\Module\Issue\Domain\Exception\InvalidIssueCodeException;
use App\Module\Issue\Domain\Exception\ProjectToAddIssueNotExistsException;
use App\Module\Issue\Domain\Exception\UserToAssigneeIssueNotExistsException;

class ApiException extends AbstractApiException
{
    public const INVALID_ISSUE_CODE = 1;
    public const PROJECT_TO_ADD_ISSUE_NOT_EXISTS = 2;
    public const USER_TO_ASSIGNEE_ISSUE_NOT_EXISTS = 3;

    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): ?array
    {
        return [
            InvalidIssueCodeException::class => self::INVALID_ISSUE_CODE,
            ProjectToAddIssueNotExistsException::class => self::PROJECT_TO_ADD_ISSUE_NOT_EXISTS,
            UserToAssigneeIssueNotExistsException::class => self::USER_TO_ASSIGNEE_ISSUE_NOT_EXISTS
        ];
    }
}