<?php

namespace App\Module\Account\Api\Mapper;

use App\Module\Account\Api\Output\AccountOutput;
use App\Module\Account\App\Data\AccountData;

class AccountMapper
{
    public static function getAccountOutput(AccountData $data): AccountOutput
    {
        return new AccountOutput(
            $data->getId(),
            $data->getOwnerId(),
            $data->getCreatedAt()
        );
    }
}