<?php

namespace App\Module\Issue\Api\Extendable;

use App\Module\Issue\Domain\Model\IssueFieldType as IssueFieldTypeDomain;

class IssueFieldType
{
    public const STRING = IssueFieldTypeDomain::STRING;
    public const TIME_INTERVAL = IssueFieldTypeDomain::TIME_INTERVAL;
}