<?php

namespace App\Module\FuzzyIntegration\App\Service;

use App\Common\Domain\Utils\Arrays;
use App\Module\FuzzyIntegration\App\Data\CalculateDeveloperLevelSpecificationInterface;
use App\Module\FuzzyIntegration\App\Exception\FailedToDefuzzycateException;
use App\Module\FuzzyIntegration\App\Exception\InvalidServiceRequestException;
use App\Module\FuzzyIntegration\App\Exception\UnexpectedServiceResponseException;
use App\Module\FuzzyIntegration\Domain\Model\DeveloperLevel;

class FuzzyLogicService
{
    private FuzzyGatewayServiceInterface $gatewayService;

    public function __construct(FuzzyGatewayServiceInterface $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    /**
     * @param CalculateDeveloperLevelSpecificationInterface $specification
     * @return int
     * @throws InvalidServiceRequestException
     * @throws UnexpectedServiceResponseException
     * @throws FailedToDefuzzycateException
     */
    public function calculateDeveloperLevel(CalculateDeveloperLevelSpecificationInterface $specification): int
    {
        $level = $this->gatewayService->calculate($specification->getDifficulty(), $specification->getTime());

        [$defuzzycatedLevel, $range] = Arrays::findIf(DeveloperLevel::getRanges(),
            static fn(int $level, array $range) => Arrays::between($range, $level),
            true
        );

        if ($defuzzycatedLevel === null)
        {
            throw new FailedToDefuzzycateException('', ['level' => $level]);
        }

        return $defuzzycatedLevel;
    }
}