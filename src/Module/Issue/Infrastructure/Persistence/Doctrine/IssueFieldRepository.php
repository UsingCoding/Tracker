<?php

namespace App\Module\Issue\Infrastructure\Persistence\Doctrine;

use App\Module\Issue\Domain\Model\IssueField;
use App\Module\Issue\Domain\Model\IssueFieldRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class IssueFieldRepository implements IssueFieldRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(IssueField::class);
    }

    public function add(IssueField $issue): void
    {
        $this->entityManager->persist($issue);
    }

    public function findById(int $id): ?IssueField
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function remove(IssueField $issue): void
    {
        $this->entityManager->remove($issue);
    }
}