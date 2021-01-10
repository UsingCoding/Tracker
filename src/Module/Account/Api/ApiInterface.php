<?php

namespace App\Module\Account\Api;

use App\Module\Account\Api\Exception\ApiException;
use App\Module\Account\Api\Output\AccountOutput;

interface ApiInterface
{
    /**
     * @param CreateAccountInput $input
     * @throws ApiException
     */
    public function createAccount(CreateAccountInput $input): void;

    /**
     * @return AccountOutput
     * @throws ApiException
     */
    public function getAccount(): AccountOutput;
}