<?php

namespace App\Module\FuzzyIntegration\Api\Input;

use App\Module\FuzzyIntegration\App\Data\CalculateDeveloperLevelSpecificationInterface;

class CalculateDeveloperLevelInput implements CalculateDeveloperLevelSpecificationInterface
{
    private int $difficulty;
    private int $time;

    public function __construct(int $difficulty, int $time)
    {
        $this->difficulty = $difficulty;
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }
}