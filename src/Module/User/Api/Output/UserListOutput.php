<?php

namespace App\Module\User\Api\Output;

class UserListOutput
{
    /** @var UserOutput[] */
    private array $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * @return UserOutput[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}