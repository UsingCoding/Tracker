<?php

namespace App\Common\Domain\Event;

interface DomainEventHandlerInterface
{
    /**
     * @param DomainEventInterface $event
     * @throws \Exception
     */
    public function handle(DomainEventInterface $event): void;

    public function isSubscribedTo(DomainEventInterface $event): bool;
}