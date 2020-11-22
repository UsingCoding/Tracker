<?php

namespace App\Module\Account\App\Query;

use App\Module\Account\App\Data\AccountData;
use App\Module\Account\App\Query\Exception\AccountNotFoundException;

interface AccountQueryServiceInterface
{
    /**
     * @param string $domainName
     * @return AccountData
     * @throws AccountNotFoundException
     */
    public function getByDomainName(string $domainName): AccountData;
}