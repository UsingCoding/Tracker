<?php

namespace App\Module\FuzzyIntegration\Api\Terms;

use App\Module\FuzzyIntegration\Domain\Model\IssueTime as IssueTimeDomain;

class IssueTime
{
    public const VERY_URGENT = IssueTimeDomain::VERY_URGENT;
    public const URGENT = IssueTimeDomain::URGENT;
    public const REGULAR = IssueTimeDomain::REGULAR;
    public const LONG = IssueTimeDomain::REGULAR;
    public const VERY_LONG = IssueTimeDomain::VERY_LONG;
}