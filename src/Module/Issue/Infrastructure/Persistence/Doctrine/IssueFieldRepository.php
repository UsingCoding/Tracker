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
        $this->entityManager->flush();
    }

    public function findById(int $id): ?IssueField
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function findByNameInProject(string $name, int $projectId): ?IssueField
    {
        return $this->repo->findOneBy(['name' => $name, 'projectId' => $projectId]);
    }

    public function remove(IssueField $issue): void
    {
        $this->entityManager->remove($issue);
    }

    public function findForProject(int $projectId): array
    {
        return $this->repo->findBy(['projectId' => $projectId]);
    }
}