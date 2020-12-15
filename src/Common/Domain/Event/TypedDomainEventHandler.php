<?php

namespace App\Common\Domain\Event;

abstract class TypedDomainEventHandler implements DomainEventHandlerInterface
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function isSubscribedTo(DomainEventInterface $event): bool
    {
        return $event->getType() === $this->type;
    }

}