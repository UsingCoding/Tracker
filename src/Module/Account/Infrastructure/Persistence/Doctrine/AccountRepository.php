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
//        $this->repo = $this->mainEntityManager->getRepository(Account::class);
    }

    public function add(Account $account): void
    {
        $this->mainEntityManager->persist($account);
    }

    public function findById(int $accountId): ?Account
    {
        return null;
//        return $this->repo->findOneBy(['account_id' => $accountId]);
    }

    public function findByDomainName(string $domainName): ?Account
    {
        return null;
//        return $this->repo->findOneBy(['domain_name' => $domainName]);
    }

    public function remove(Account $account): void
    {
        $this->mainEntityManager->remove($account);
    }
}