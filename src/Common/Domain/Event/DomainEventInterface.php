<?php

namespace App\Common\Domain\Event;

interface DomainEventInterface
{
    public function getType(): string;
}