<?php

namespace App\Common\Domain\Event;

interface DomainEventDispatcherInterface
{
    /**
     * @param DomainEventInterface $event
     * @throws \Exception
     */
    public function dispatch(DomainEventInterface $event): void;
}