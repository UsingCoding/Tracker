<?php

namespace App\Common\App\Command\Bus;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\Registry\CommandHandlerRegistryInterface;

class AppCommandBus implements AppCommandBusInterface
{
    private CommandHandlerRegistryInterface $commandHandlerRegistry;

    public function __construct(CommandHandlerRegistryInterface $commandHandlerRegistry)
    {
        $this->commandHandlerRegistry = $commandHandlerRegistry;
    }

    public function publish(CommandInterface $command): void
    {
        $handler = $this->commandHandlerRegistry->getCommandHandler($command);
        $handler->handle($command);
    }
}