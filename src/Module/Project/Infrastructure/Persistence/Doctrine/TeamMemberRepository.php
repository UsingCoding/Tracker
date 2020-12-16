<?php

namespace App\Module\Project\Infrastructure\Persistence\Doctrine;

use App\Module\Project\Domain\Model\TeamMember;
use App\Module\Project\Domain\Model\TeamMemberRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class TeamMemberRepository implements TeamMemberRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $this->entityManager->getRepository(TeamMember::class);
    }
    public function add(TeamMember $teamMember): void
    {
        $this->entityManager->persist($teamMember);
    }

    public function findById(int $id): ?TeamMember
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function remove(TeamMember $teamMember): void
    {
        $this->entityManager->remove($teamMember);
    }
}