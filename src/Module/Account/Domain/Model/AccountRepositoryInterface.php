<?php

namespace App\Module\Account\Domain\Model;

interface AccountRepositoryInterface
{
    public function add(Account $account): void;

    public function get(): ?Account;

    public function remove(Account $account): void;
}