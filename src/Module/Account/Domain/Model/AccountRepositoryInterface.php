<?php

namespace App\Module\Account\Domain\Model;

interface AccountRepositoryInterface
{
    public function add(Account $account): void;

    public function findById(int $accountId): ?Account;

    public function findByDomainName(string $domainName): ?Account;

    public function remove(Account $account): void;
}