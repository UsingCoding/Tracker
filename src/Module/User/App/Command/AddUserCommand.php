<?php

namespace App\Module\User\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\User\App\Data\AddUserRequestInterface;

class AddUserCommand extends AbstractCommand
{
    public const TYPE = 'user.add_user';

    public const EMAIL = 'email';
    public const USERNAME = 'username';
    public const PASSWORD = 'password';
    public const GRADE = 'grade';

    public function __construct(AddUserRequestInterface $request)
    {
        parent::__construct([
            self::EMAIL => $request->getEmail(),
            self::USERNAME => $request->getUsername(),
            self::PASSWORD => $request->getPassword(),
            self::GRADE => $request->getGrade()
        ]);
    }
}