<?php

namespace App\Module\FuzzyIntegration\Api;

use App\Module\FuzzyIntegration\Api\Exception\ApiException;
use App\Module\FuzzyIntegration\Api\Input\CalculateDeveloperLevelInput;

interface ApiInterface
{
    /**
     * @param CalculateDeveloperLevelInput $input
     * @return int
     * @throws ApiException
     */
    public function calculateDeveloperLevel(CalculateDeveloperLevelInput $input): int;
}