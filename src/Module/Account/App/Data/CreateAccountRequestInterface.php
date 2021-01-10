<?php

namespace App\Module\Account\App\Data;

interface CreateAccountRequestInterface
{
    public function getUserId(): int;
}