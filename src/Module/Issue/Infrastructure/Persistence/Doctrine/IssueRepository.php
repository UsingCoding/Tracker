<?php

namespace App\Module\Issue\Infrastructure\Persistence\Doctrine;

use App\Common\Domain\Utils\Arrays;
use App\Common\Infrastructure\Persistence\OrderByType;
use App\Module\Issue\Domain\Model\Issue;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class IssueRepository implements IssueRepositoryInterface
{
    private const INCREMENT_INDEX = 1;
    private const START_INDEX = 1;

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

    public function getNextInProjectId(int $projectId): int
    {
        /** @var Issue[]|null[] $issuesInProject */
        $issuesInProject = $this->repo->findBy(['projectId' => $projectId], ['inProjectId' => OrderByType::DESC], 1);

        if (Arrays::length($issuesInProject) === 0)
        {
            return self::START_INDEX;
        }

        return $issuesInProject[0]->getInProjectId() + self::INCREMENT_INDEX;
    }

    public function findForProject(int $projectId): array
    {
        return $this->repo->findBy(['projectId' => $projectId]);
    }

    public function findById(int $id): ?Issue
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function remove(Issue $issue): void
    {
        $this->entityManager->remove($issue);
    }
}