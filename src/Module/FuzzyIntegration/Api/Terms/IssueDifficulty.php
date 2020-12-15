<?php

namespace App\Module\FuzzyIntegration\Api\Terms;

use App\Module\FuzzyIntegration\Domain\Model\IssueDifficulty as IssueDifficultyDomain;

class IssueDifficulty
{
    public const EASY = IssueDifficultyDomain::EASY;
    public const MEDIUM = IssueDifficultyDomain::MEDIUM;
    public const HARD = IssueDifficultyDomain::HARD;
}