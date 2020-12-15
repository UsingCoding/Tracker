<?php

namespace App\Module\FuzzyIntegration\App\Service;

use App\Module\FuzzyIntegration\App\Exception\InvalidServiceRequestException;
use App\Module\FuzzyIntegration\App\Exception\UnexpectedServiceResponseException;

interface FuzzyGatewayServiceInterface
{
    /**
     * @param int $difficulty
     * @param int $time
     * @return int
     * @throws InvalidServiceRequestException
     * @throws UnexpectedServiceResponseException
     */
    public function calculate(int $difficulty, int $time): int;
}