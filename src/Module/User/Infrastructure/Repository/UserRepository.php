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

    public function getUserByEmail(string $email): void
    {
//        $query = $this->entityManager->createQuery('select * from client where email = :email limit 1')->setParameter('email', $email);
//
//        $result = $query->getResult();
//
//        $this->logger->debug('RESULT', [$result]);

//        $this->logger->debug("URL", [$this->parameterBag->get('app.url')]);

        $connection = $this->accountEntityManager->getConnection();

        $sql = 'select * from client where email = :email limit 1';

        $stmt = $connection->prepare($sql);
        $stmt->execute(['email' => $email]);

        $this->logger->debug("DATA", [$stmt->fetchOne()]);

//        $dbconn = pg_connect("host=db dbname=main user=root password=1234");
//
//        $res = pg_query($sql);
//
//        $line = pg_fetch_array($res, null, PGSQL_ASSOC);
//
//        $this->logger->debug('RESULT', [$line]);
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