<?php

namespace App\Common\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Exception\InvalidCommandException;

interface AppCommandHandlerInterface
{
    /**
     * @param CommandInterface $command
     * @throws InvalidCommandException
     */
    public function handle(CommandInterface $command): void;
}