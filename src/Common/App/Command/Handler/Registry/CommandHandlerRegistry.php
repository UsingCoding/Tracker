<?php

namespace App\Common\App\Command\Handler\Registry;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;

class CommandHandlerRegistry implements CommandHandlerRegistryInterface
{
    private array $handlers = [];

    public function registerHandler(string $commandType, AppCommandHandlerInterface $handler): void
    {
        if (isset($this->handlers[$commandType]))
        {
            throw new \LogicException("Cannot set several handler at the same {$commandType}");
        }

        $this->handlers[$commandType] = $handler;
    }

    public function getCommandHandler(CommandInterface $command): AppCommandHandlerInterface
    {
        $commandType = $command->getType();
        if (!isset($this->handlers[$commandType]))
        {
            throw new \LogicException("There is no registered command handler for {$commandType}");
        }

        return $this->handlers[$commandType];
    }
}