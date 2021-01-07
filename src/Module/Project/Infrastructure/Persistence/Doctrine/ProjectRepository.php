<?php


namespace App\Module\Project\Infrastructure\Persistence\Doctrine;


use App\Module\Project\Domain\Model\Project;
use App\Module\Project\Domain\Model\ProjectRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ProjectRepository implements ProjectRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(Project::class);
    }

    public function add(Project $project): void
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?Project
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function findByNameId(string $nameId): ?Project
    {
        return $this->repo->findOneBy(['nameId' => $nameId]);
    }

    public function remove(Project $project): void
    {
        $this->entityManager->remove($project);
    }
}