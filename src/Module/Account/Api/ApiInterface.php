<?php

namespace App\Module\Account\Api;

use App\Module\Account\Api\Output\AccountOutput;

interface ApiInterface
{
    public function getAccountByDomain(string $domainName): AccountOutput;
}