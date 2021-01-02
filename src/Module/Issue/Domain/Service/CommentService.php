<?php

namespace App\Module\Issue\Domain\Service;

use App\Module\Issue\Domain\Adapter\UserAdapterInterface;
use App\Module\Issue\Domain\Exception\CommentByIdNotFoundException;
use App\Module\Issue\Domain\Exception\IssueByIdNotFoundException;
use App\Module\Issue\Domain\Exception\UserToAddCommentNotExistsException;
use App\Module\Issue\Domain\Model\Comment;
use App\Module\Issue\Domain\Model\CommentRepositoryInterface;
use App\Module\Issue\Domain\Model\IssueRepositoryInterface;

class CommentService
{
    private CommentRepositoryInterface $commentRepo;
    private IssueRepositoryInterface $issueRepo;
    private UserAdapterInterface $userAdapter;

    public function __construct(CommentRepositoryInterface $commentRepo, IssueRepositoryInterface $issueRepo, UserAdapterInterface $userAdapter)
    {
        $this->commentRepo = $commentRepo;
        $this->issueRepo = $issueRepo;
        $this->userAdapter = $userAdapter;
    }

    /**
     * @param int $issueId
     * @param int $userId
     * @param string $content
     * @return Comment
     * @throws IssueByIdNotFoundException
     * @throws UserToAddCommentNotExistsException
     */
    public function addComment(int $issueId, int $userId, string $content): Comment
    {
        $this->assertIssueExists($issueId);
        $this->assertUserExists($userId);

        $comment = new Comment(
            null,
            $issueId,
            $userId,
            $content
        );

        $this->commentRepo->add($comment);

        return $comment;
    }

    /**
     * @param int $commentId
     * @throws CommentByIdNotFoundException
     */
    public function deleteComment(int $commentId): void
    {
        $comment = $this->commentRepo->findById($commentId);

        if ($comment === null)
        {
            throw new CommentByIdNotFoundException('', ['comment_id' => $commentId]);
        }

        $this->commentRepo->remove($comment);
    }

    /**
     * @param int $issueId
     * @throws IssueByIdNotFoundException
     */
    private function assertIssueExists(int $issueId): void
    {
        if ($this->issueRepo->findById($issueId) === null)
        {
            throw new IssueByIdNotFoundException('', ['issue_id' => $issueId]);
        }
    }

    /**
     * @param int $userId
     * @throws UserToAddCommentNotExistsException
     */
    private function assertUserExists(int $userId): void
    {
        $user = $this->userAdapter->getUserById($userId);

        if ($user === null)
        {
            throw new UserToAddCommentNotExistsException('User not exists', ['user_id' => $userId]);
        }
    }
}