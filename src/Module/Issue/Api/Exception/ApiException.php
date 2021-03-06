<?php

namespace App\Module\Issue\Api\Exception;

use App\Common\Api\Exception\AbstractApiException;
use App\Module\Issue\Domain\Exception\CommentByIdNotFoundException;
use App\Module\Issue\Domain\Exception\InvalidIssueCodeException;
use App\Module\Issue\Domain\Exception\InvalidIssueFieldDataException;
use App\Module\Issue\Domain\Exception\IssueByIdNotFoundException;
use App\Module\Issue\Domain\Exception\IssueFieldByIdNotFoundException;
use App\Module\Issue\Domain\Exception\IssueNameBusyException;
use App\Module\Issue\Domain\Exception\ProjectToAddIssueNotExistsException;
use App\Module\Issue\Domain\Exception\UserToAddCommentNotExistsException;
use App\Module\Issue\Domain\Exception\UserToAssigneeIssueNotExistsException;

class ApiException extends AbstractApiException
{
    public const INVALID_ISSUE_CODE = 1;
    public const PROJECT_TO_ADD_ISSUE_NOT_EXISTS = 2;
    public const USER_TO_ASSIGNEE_ISSUE_NOT_EXISTS = 3;
    public const ISSUE_BY_ID_NOT_FOUND = 4;

    public const ISSUE_FIELD_NAME_BUSY = 5;
    public const ISSUE_FIELD_BY_NOT_FOUND = 6;
    public const INVALID_ISSUE_FIELD_DATA = 7;

    public const USER_TO_ADD_COMMENT_NOT_EXISTS = 8;
    public const COMMENT_BY_ID_NOT_FOUND = 9;

    protected static function getSelf(): string
    {
        return __CLASS__;
    }

    protected static function getExceptionMap(): ?array
    {
        return [
            InvalidIssueCodeException::class => self::INVALID_ISSUE_CODE,
            ProjectToAddIssueNotExistsException::class => self::PROJECT_TO_ADD_ISSUE_NOT_EXISTS,
            UserToAssigneeIssueNotExistsException::class => self::USER_TO_ASSIGNEE_ISSUE_NOT_EXISTS,
            IssueByIdNotFoundException::class => self::ISSUE_BY_ID_NOT_FOUND,
            IssueNameBusyException::class => self::ISSUE_FIELD_NAME_BUSY,
            IssueFieldByIdNotFoundException::class => self::ISSUE_FIELD_BY_NOT_FOUND,
            InvalidIssueFieldDataException::class => self::INVALID_ISSUE_FIELD_DATA,
            UserToAddCommentNotExistsException::class => self::USER_TO_ADD_COMMENT_NOT_EXISTS,
            CommentByIdNotFoundException::class => self::COMMENT_BY_ID_NOT_FOUND
        ];
    }
}