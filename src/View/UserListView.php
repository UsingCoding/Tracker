<?php

namespace App\View;

use App\Common\Domain\Utils\Arrays;
use App\Common\Domain\Utils\Date;
use App\Module\User\Api\Output\UserListOutput;
use App\Module\User\Api\Output\UserOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserListView
{
    private UserListOutput $usersList;

    public function __construct(UserListOutput $usersList)
    {
        $this->usersList = $usersList;
    }

    public function render(): Response
    {
        return new JsonResponse(Arrays::map($this->usersList->getUsers(),
            static fn(UserOutput $output) => [
                'id' => $output->getUserId(),
                'username' => $output->getUsername(),
                'password' => $output->getPassword(),
                'created_at' => $output->getCreatedAt()->format(Date::DEFAULT_ISSUE_TIME_FORMAT),
                'email' => $output->getEmail(),
                'grade' => $output->getGrade()
            ]
        ));
    }
}