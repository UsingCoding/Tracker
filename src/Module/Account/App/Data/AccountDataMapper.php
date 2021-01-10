<?php

namespace App\Module\Account\App\Data;

use App\Module\Account\Domain\Model\Account;

class AccountDataMapper
{
    public static function accountToAccountData(Account $account): AccountData
    {
        return new AccountData(
            $account->getId(),
            $account->getOwnerId(),
            $account->getCreatedAt()
        );
    }
}