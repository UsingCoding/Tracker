<?php

namespace App\Module\Issue\App\Query;

use App\Module\Issue\App\Query\Data\IssueData;
use App\Module\Issue\Domain\Exception\InvalidIssueCodeException;

interface IssueQueryServiceInterface
{
    /**
     * @param string $code
     * @return IssueData|null
     * @throws InvalidIssueCodeException
     * @throws \Exception
     */
    public function getIssue(string $code): ?IssueData;
}