<?php

namespace App\Module\User\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\User\App\Data\EditUserRequestInterface;

class EditUserCommand extends AbstractCommand
{
    public const TYPE = 'user.edit_user';

    public const USER_ID = 'user_id';
    public const EMAIL = 'email';
    public const USERNAME = 'username';
    public const PASSWORD = 'password';
    public const GRADE = 'grade';

    public function __construct(EditUserRequestInterface $request)
    {
        parent::__construct([
            self::USER_ID => $request->getUserId(),
            self::EMAIL => $request->getEmail(),
            self::USERNAME => $request->getUsername(),
            self::PASSWORD => $request->getPassword(),
            self::GRADE => $request->getGrade()
        ]);
    }
}