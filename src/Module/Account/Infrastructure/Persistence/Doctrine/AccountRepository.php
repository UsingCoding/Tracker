<?php

namespace App\Module\Account\Infrastructure\Persistence\Doctrine;

use App\Module\Account\Domain\Model\Account;
use App\Module\Account\Domain\Model\AccountRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class AccountRepository implements AccountRepositoryInterface
{
    private EntityManagerInterface $mainEntityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $mainEntityManager)
    {
        $this->mainEntityManager = $mainEntityManager;
        $this->repo = $this->mainEntityManager->getRepository(Account::class);
    }

    public function add(Account $account): void
    {
        $this->mainEntityManager->persist($account);
    }

    public function get(): ?Account
    {
        return $this->repo->findOneBy([]);
    }

    public function remove(Account $account): void
    {
        $this->mainEntityManager->remove($account);
    }
}