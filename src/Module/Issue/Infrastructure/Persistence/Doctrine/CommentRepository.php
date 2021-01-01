<?php

namespace App\Module\Issue\Infrastructure\Persistence\Doctrine;

use App\Module\Issue\Domain\Model\Comment;
use App\Module\Issue\Domain\Model\CommentRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class CommentRepository implements CommentRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->repo = $this->entityManager->getRepository(Comment::class);
    }

    public function add(Comment $comment): void
    {
        $this->entityManager->persist($comment);
    }

    public function findById(int $id): ?Comment
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function remove(Comment $comment): void
    {
        $this->entityManager->remove($comment);
    }
}