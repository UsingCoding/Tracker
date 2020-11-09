<?php

namespace App\Module\User\Infrastructure\Repository;

use App\Module\User\Domain\Service\UserRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ParameterBagInterface $parameterBag;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
        $this->logger = $logger;
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
}