<?php

namespace App\Module\User\App\Event;

use App\Common\App\Event\AppEventInterface;

class UserAddedEvent implements AppEventInterface
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}