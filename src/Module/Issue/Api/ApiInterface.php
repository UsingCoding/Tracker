<?php

namespace App\Module\Issue\Api;

use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\CreateIssueInput;

interface ApiInterface
{
    /**
     * @param CreateIssueInput $input
     * @return int
     * @throws ApiException
     */
    public function createIssue(CreateIssueInput $input): int;
}