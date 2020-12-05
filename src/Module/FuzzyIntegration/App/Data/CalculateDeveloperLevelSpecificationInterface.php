<?php

namespace App\Module\FuzzyIntegration\App\Data;

interface CalculateDeveloperLevelSpecificationInterface
{
    public function getDifficulty(): int;
    public function getTime(): int;
}