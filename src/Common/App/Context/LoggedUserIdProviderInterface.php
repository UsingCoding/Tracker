<?php

namespace App\Common\App\Context;

interface LoggedUserIdProviderInterface
{
    /**
     * @return int|null null means that no logged user
     */
    public function getUserId(): ?int;
}