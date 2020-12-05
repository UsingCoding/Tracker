<?php

namespace App\Module\FuzzyIntegration\Api\Terms;

use App\Module\FuzzyIntegration\Domain\Model\DeveloperLevel as DeveloperLevelDomain;

class DeveloperLevel
{
    public const JUNIOR = DeveloperLevelDomain::JUNIOR;
    public const MIDDLE = DeveloperLevelDomain::MIDDLE;
    public const SENIOR = DeveloperLevelDomain::SENIOR;
    public const ARCHITECT = DeveloperLevelDomain::ARCHITECT;
}