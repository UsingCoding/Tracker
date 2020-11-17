<?php

namespace App\Common\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Exception\InvalidCommandException;
use Throwable;

interface AppCommandHandlerInterface
{
    /**
     * @param CommandInterface $command
     * @throws InvalidCommandException
     * @throws Throwable
     */
    public function execute(CommandInterface $command): void;
}