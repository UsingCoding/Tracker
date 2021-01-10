<?php

namespace App\Module\Account\Infrastructure\Query;

use App\Module\Account\App\Data\AccountData;
use App\Module\Account\App\Data\AccountDataMapper;
use App\Module\Account\App\Query\AccountQueryServiceInterface;
use App\Module\Account\App\Query\Exception\AccountNotFoundException;
use App\Module\Account\Domain\Model\AccountRepositoryInterface;

class AccountQueryService implements AccountQueryServiceInterface
{
    private AccountRepositoryInterface $accountRepo;

    public function __construct(AccountRepositoryInterface $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    public function get(): AccountData
    {
        $account = $this->accountRepo->get();

        if ($account === null)
        {
            throw new AccountNotFoundException('account not found');
        }

        return AccountDataMapper::accountToAccountData($account);
    }
}