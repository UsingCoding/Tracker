<?php

namespace App\Module\User\App\Command;

use App\Common\App\Command\AbstractCommand;

class DeleteUserCommand extends AbstractCommand
{
    public const TYPE = 'user.delete_user';

    public const USER_ID = 'user_id';

    public function __construct(int $userId)
    {
        parent::__construct([self::USER_ID => $userId]);
    }
}