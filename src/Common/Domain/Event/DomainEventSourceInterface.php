<?php

namespace App\Common\Domain\Event;

interface DomainEventSourceInterface
{
    public function subscribe(DomainEventHandlerInterface $handler): void;

    public function unsubscribe(DomainEventHandlerInterface $handler): void;
}