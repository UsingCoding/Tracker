<?php

namespace App\Common\App\Command\Bus;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Exception\InvalidCommandException;

interface AppCommandBusInterface
{
    /**
     * @param CommandInterface $command
     * @throws InvalidCommandException
     */
    public function publish(CommandInterface $command): void;
}