<?php

namespace App\Common\App\Command\Handler\Registry;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;

interface CommandHandlerRegistryInterface
{
    public function registerHandler(string $commandType, AppCommandHandlerInterface $handler): void;

    public function getCommandHandler(CommandInterface $command): AppCommandHandlerInterface;
}