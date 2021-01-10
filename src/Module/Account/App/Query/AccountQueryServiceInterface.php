<?php

namespace App\Module\Account\App\Query;

use App\Module\Account\App\Data\AccountData;
use App\Module\Account\App\Query\Exception\AccountNotFoundException;

interface AccountQueryServiceInterface
{
    /**
     * @return AccountData
     * @throws AccountNotFoundException
     */
    public function get(): AccountData;
}