<?php

namespace App\Module\Issue\Infrastructure\Persistence\Doctrine;

use App\Module\Issue\Domain\Model\Issue;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class IssueRepository implements IssueRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(Issue::class);
    }

    public function add(Issue $issue): void
    {
        $this->entityManager->persist($issue);
    }

    public function findById(int $id): ?Issue
    {
        $this->repo->findOneBy(['id' => $id]);
    }

    public function remove(Issue $issue): void
    {
        $this->entityManager->remove($issue);
    }
}