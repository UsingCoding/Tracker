<?php

namespace App\Module\FuzzyIntegration\Api;

use App\Module\FuzzyIntegration\Api\Exception\ApiException;
use App\Module\FuzzyIntegration\Api\Input\CalculateDeveloperLevelInput;
use App\Module\FuzzyIntegration\App\Service\FuzzyLogicService;

class Api implements ApiInterface
{
    private FuzzyLogicService $fuzzyLogicService;

    public function __construct(FuzzyLogicService $fuzzyLogicService)
    {
        $this->fuzzyLogicService = $fuzzyLogicService;
    }

    public function calculateDeveloperLevel(CalculateDeveloperLevelInput $input): int
    {
        try
        {
            return $this->fuzzyLogicService->calculateDeveloperLevel($input);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}