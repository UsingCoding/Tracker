<?php

namespace App\Module\User\Infrastructure\Repository;

use App\Module\User\Domain\Model\User;
use App\Module\User\Domain\Model\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(User::class);
    }

    public function getUserByEmail(string $email): void
    {
//        $query = $this->entityManager->createQuery('select * from client where email = :email limit 1')->setParameter('email', $email);
//
//        $result = $query->getResult();
//
//        $this->logger->debug('RESULT', [$result]);

//        $this->logger->debug("URL", [$this->parameterBag->get('app.url')]);

        $connection = $this->entityManager->getConnection();

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
        $this->entityManager->persist($user);
    }

    public function findById(int $id): ?User
    {
        return $this->repo->findOneBy(['user_id' => $id]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repo->findOneBy(['email' => $email]);
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
    }
}