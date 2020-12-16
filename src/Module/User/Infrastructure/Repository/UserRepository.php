<?php

namespace App\Module\User\Infrastructure\Repository;

use App\Module\User\Domain\Model\User;
use App\Module\User\Domain\Model\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $accountEntityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $accountEntityManager)
    {
        $this->accountEntityManager = $accountEntityManager;
        $this->repo = $this->accountEntityManager->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->accountEntityManager->persist($user);
    }

    public function findById(int $id): ?User
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repo->findOneBy(['email' => $email]);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->repo->findOneBy(['username' => $username]);
    }

    public function remove(User $user): void
    {
        $this->accountEntityManager->remove($user);
    }
}