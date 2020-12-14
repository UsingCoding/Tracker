<?php

namespace App\Common\App\Event;

use App\Common\Domain\Event\DomainEventDispatcherInterface;
use App\Common\Domain\Event\DomainEventHandlerInterface;
use App\Common\Domain\Event\DomainEventInterface;
use App\Common\Domain\Event\DomainEventSourceInterface;
use App\Common\Domain\Utils\Arrays;

class DomainEventDispatcher implements DomainEventSourceInterface, DomainEventDispatcherInterface
{
    /** @var DomainEventHandlerInterface[] */
    private array $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * @throws \BadMethodCallException
     */
    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }

    public function dispatch(DomainEventInterface $event): void
    {
        foreach ($this->handlers as $handler)
        {
            if ($handler->isSubscribedTo($event))
            {
                $handler->handle($event);
            }
        }
    }

    public function subscribe(DomainEventHandlerInterface $handler): void
    {
        $this->handlers[spl_object_hash($handler)] = $handler;
    }

    public function unsubscribe(DomainEventHandlerInterface $handler): void
    {
        Arrays::removeByKey($this->handlers, spl_object_hash($handler));
    }
}