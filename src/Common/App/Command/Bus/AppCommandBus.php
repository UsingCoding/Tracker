<?php

namespace App\Common\App\Command\Bus;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\Registry\CommandHandlerRegistryInterface;
use Psr\Log\LoggerInterface;

class AppCommandBus implements AppCommandBusInterface
{
    private CommandHandlerRegistryInterface $commandHandlerRegistry;
    private LoggerInterface $logger;

    public function __construct(CommandHandlerRegistryInterface $commandHandlerRegistry, \Psr\Log\LoggerInterface $logger)
    {
        $this->commandHandlerRegistry = $commandHandlerRegistry;
        $this->logger = $logger;
    }

    public function publish(CommandInterface $command): void
    {
        $handler = $this->commandHandlerRegistry->getCommandHandler($command);

        $this->logger->debug('Sending command to handler', [
            'command' => get_class($command),
            'handler' => get_class($handler)
        ]);

        $handler->execute($command);
    }
}