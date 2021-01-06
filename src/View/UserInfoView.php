<?php

namespace App\View;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Domain\Utils\Date;
use App\Common\Infrastructure\Context\AvatarUrlProvider;
use App\Module\User\Api\Output\UserOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserInfoView implements RenderableViewInterface
{
    private UserOutput $user;
    private AvatarUrlProvider $avatarUrlProvider;

    public function __construct(UserOutput $user, AvatarUrlProvider $avatarUrlProvider)
    {
        $this->user = $user;
        $this->avatarUrlProvider = $avatarUrlProvider;
    }

    public function render(): Response
    {
        return new JsonResponse([
            'username' => $this->user->getUsername(),
            'password' => $this->user->getPassword(),
            'email' => $this->user->getEmail(),
            'created_at' => $this->user->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
            'grade' => $this->user->getGrade(),
            'avatar_url' => $this->avatarUrlProvider->getUrl($this->user->getAvatarUrl())
        ]);
    }
}