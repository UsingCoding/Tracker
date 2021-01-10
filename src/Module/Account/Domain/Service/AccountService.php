<?php

namespace App\Module\Account\Domain\Service;

use App\Module\Account\Domain\Adapter\UserAdapterInterface;
use App\Module\Account\Domain\Model\Account;
use App\Module\Account\Domain\Model\AccountRepositoryInterface;
use App\Module\Account\Domain\UserNotFoundException;

class AccountService
{
    private AccountRepositoryInterface $accountRepo;
    private UserAdapterInterface $userAdapter;

    public function __construct(AccountRepositoryInterface $accountRepo, UserAdapterInterface $userAdapter)
    {
        $this->accountRepo = $accountRepo;
        $this->userAdapter = $userAdapter;
    }

    /**
     * @param int $ownerId
     * @return Account
     * @throws UserNotFoundException
     */
    public function createAccount(int $ownerId): Account
    {
        $this->assertUserExists($ownerId);

        $account = new Account(
            null,
            $ownerId,
            new \DateTimeImmutable()
        );

        $this->accountRepo->add($account);

        return $account;
    }

    /**
     * @param int $userId
     * @throws UserNotFoundException
     */
    private function assertUserExists(int $userId): void
    {
        if ($this->userAdapter->getUserById($userId) === null)
        {
            throw new UserNotFoundException('', ['user_id' => $userId]);
        }
    }
}