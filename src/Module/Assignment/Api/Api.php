<?php

namespace App\Module\Assignment\Api;

use App\Module\Assignment\Api\Exception\ApiException;
use App\Module\Assignment\Api\Input\AutoAssignInput;
use App\Module\Assignment\App\Service\AssigmentService;

class Api implements ApiInterface
{
    private AssigmentService $assigmentService;

    public function __construct(AssigmentService $assigmentService)
    {
        $this->assigmentService = $assigmentService;
    }


    public function isAutoAssigmentAvailable(int $projectId): bool
    {
        try
        {
            return $this->assigmentService->isAutoAssigmentAvailable($projectId);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }

    public function autoAssign(AutoAssignInput $input): void
    {
        // TODO: Implement autoAssign() method.
    }
}