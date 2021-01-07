<?php

namespace App\View;

use App\Common\Domain\Utils\Arrays;
use App\Common\Domain\Utils\Date;
use App\Framework\Infrastructure\Security\User\User;
use App\Module\User\Api\Output\UserListOutput;
use App\Module\User\Api\Output\UserOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserListView
{
    private UserListOutput $usersList;
    private User $loggedUser;

    public function __construct(UserListOutput $usersList, User $loggedUser)
    {
        $this->usersList = $usersList;
        $this->loggedUser = $loggedUser;
    }

    public function render(): Response
    {
        return new JsonResponse([
            'logged_user_id' => $this->loggedUser->getUserOutput()->getUserId(),
            'users' => Arrays::map($this->usersList->getUsers(),
                static fn(UserOutput $output) => [
                    'id' => $output->getUserId(),
                    'username' => $output->getUsername(),
                    'password' => $output->getPassword(),
                    'created_at' => $output->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
                    'email' => $output->getEmail(),
                    'grade' => $output->getGrade()
                ]
            )
        ]);
    }
}