<?php

namespace App\View;

use App\Common\App\View\RenderableTrait;
use App\Common\App\View\RenderableViewInterface;
use App\Common\Domain\Utils\Arrays;
use App\Common\Domain\Utils\Date;
use App\Common\Infrastructure\Context\AvatarUrlProvider;
use App\Module\Issue\Api\Output\CommentOutput;
use Symfony\Component\HttpFoundation\Response;

class CommentsListView implements RenderableViewInterface
{
    use RenderableTrait;

    /** @var CommentOutput[] */
    private array $comments;
    private AvatarUrlProvider $avatarUrlProvider;

    public function __construct(array $comments, AvatarUrlProvider $avatarUrlProvider)
    {
        $this->comments = $comments;
        $this->avatarUrlProvider = $avatarUrlProvider;
    }

    public function render(): Response
    {
        return $this->json(Arrays::map(
            $this->comments,
            fn(CommentOutput $output) => [
                'id' => $output->getId(),
                'username' => $output->getUsername(),
                'content' => $output->getContent(),
                'created_at' => $output->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
                'updated_at' => $output->getUpdatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
                'avatar_url' => $this->avatarUrlProvider->getUrl($output->getUserAvatarUrl())
            ]
        ));
    }
}