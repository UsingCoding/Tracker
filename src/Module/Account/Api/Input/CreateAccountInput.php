<?php

namespace App\Module\Account\Api\Input;

use App\Module\Account\App\Data\CreateAccountRequestInterface;

class CreateAccountInput implements CreateAccountRequestInterface
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