<?php

namespace App\Module\Assignment\Api;

use App\Module\Assignment\Api\Exception\ApiException;
use App\Module\Assignment\App\Exception\AutoAssigmentNotAvailableException;
use App\Module\Assignment\App\Service\AssigmentQueryServiceInterface;
use App\Module\Assignment\App\Service\AssigmentService;

class Api implements ApiInterface
{
    private AssigmentQueryServiceInterface $assigmentQueryService;
    private AssigmentService $assigmentService;

    public function __construct(AssigmentQueryServiceInterface $assigmentQueryService, AssigmentService $assigmentService)
    {
        $this->assigmentQueryService = $assigmentQueryService;
        $this->assigmentService = $assigmentService;
    }

    public function isAutoAssigmentAvailable(int $projectId): bool
    {
        try
        {
            $this->assigmentQueryService->isAutoAssigmentAvailable($projectId);

            return true;
        }
        catch (AutoAssigmentNotAvailableException $exception)
        {
            return false;
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function autoAssignIssuesInProject(int $projectId): int
    {
        try
        {
            return $this->assigmentService->autoAssigneeIssuesInProject($projectId);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}