<?php

namespace App\View;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Domain\Utils\Date;
use App\Module\User\Api\Output\UserOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserInfoView implements RenderableViewInterface
{
    private UserOutput $user;

    public function __construct(UserOutput $user)
    {
        $this->user = $user;
    }

    public function render(): Response
    {
        return new JsonResponse([
            'username' => $this->user->getUsername(),
            'password' => $this->user->getPassword(),
            'email' => $this->user->getEmail(),
            'created_at' => $this->user->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
            'grade' => $this->user->getGrade()
        ]);
    }
}