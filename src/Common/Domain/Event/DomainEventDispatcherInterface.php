<?php

namespace App\Common\Domain\Event;

interface DomainEventDispatcherInterface
{
    public function dispatch(DomainEventInterface $event): void;
}