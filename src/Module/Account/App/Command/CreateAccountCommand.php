<?php

namespace App\Module\Account\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Account\App\Data\CreateAccountRequestInterface;

class CreateAccountCommand extends AbstractCommand
{
    public const TYPE = 'account.create_account';

    public const OWNER_ID = 'owner_id';

    public function __construct(CreateAccountRequestInterface $request)
    {
        parent::__construct([
            self::OWNER_ID => $request->getUserId()
        ]);
    }
}