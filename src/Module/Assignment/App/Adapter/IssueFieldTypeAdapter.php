<?php

namespace App\Module\Assignment\App\Adapter;

use App\Module\Issue\Api\Extendable\IssueFieldType as IssueFieldTypeApi;

class IssueFieldTypeAdapter
{
    public const STRING = IssueFieldTypeApi::STRING;
    public const TIME_INTERVAL = IssueFieldTypeApi::TIME_INTERVAL;
}