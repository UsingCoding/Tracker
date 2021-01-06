<?php

namespace App\Module\Issue\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\BelongingProjectOutput;
use App\Module\Issue\Api\Output\CommentOutput;
use App\Module\Issue\Api\Output\GetIssueOutput;
use App\Module\Issue\Api\Output\IssueListItemOutput;
use App\Module\Issue\Api\Output\IssuesListOutput;
use App\Module\Issue\App\Query\Data\CommentData;
use App\Module\Issue\App\Query\Data\ExtendedIssueData;
use App\Module\Issue\App\Query\Data\IssueListItemData;
use App\Module\Issue\Domain\Service\IssueCodeService;

class IssueOutputMapper
{
    public static function getIssueOutput(ExtendedIssueData $data): GetIssueOutput
    {
        return new GetIssueOutput(
            $data->getIssue()->getIssueId(),
            $data->getIssue()->getInProjectId(),
            $data->getIssue()->getName(),
            $data->getIssue()->getDescription(),
            $data->getIssue()->getProjectName(),
            $data->getIssue()->getUsername(),
            null,
            new BelongingProjectOutput('formal'),
            (array) Arrays::map(
                $data->getComments(),
                static fn(CommentData $data) => self::getComment($data)
            ),
            $data->getIssue()->getCreatedAt(),
            $data->getIssue()->getUpdatedAt()
        );
    }

    public static function getIssueListOutput(array $data): IssuesListOutput
    {
        return new IssuesListOutput((array) Arrays::map(
            $data,
            static fn(IssueListItemData $data) =>
            new IssueListItemOutput(
                $data->getIssueId(),
                $data->getInProjectId(),
                $data->getName(),
                $data->getDescription(),
                $data->getAssigneeUsername(),
                $data->getProjectNameId(),
                IssueCodeService::getCode($data->getProjectNameId(), $data->getInProjectId()),
                $data->getFields(),
                $data->getUpdatedAt()
            ))
        );
    }

    private static function getComment(CommentData $commentData): CommentOutput
    {
        return new CommentOutput(
            $commentData->getId(),
            $commentData->getUsername(),
            $commentData->getUserAvatarUrl(),
            $commentData->getContent()
        );
    }
}