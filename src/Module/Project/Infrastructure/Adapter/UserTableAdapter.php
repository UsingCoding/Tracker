<?php

namespace App\Module\Project\Infrastructure\Adapter;

use App\Module\User\Infrastructure\Query\UserTable;

class UserTableAdapter
{
    public const USER_ID = UserTable::USER_ID;
    public const USERNAME = UserTable::USERNAME;
    public const PASSWORD = UserTable::PASSWORD;
    public const CREATED_AT = UserTable::CREATED_AT;
    public const UPDATED_AT = UserTable::UPDATED_AT;
    public const EMAIL = UserTable::EMAIL;
}