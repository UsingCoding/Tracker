<?php

namespace App\Common\App\Event;

interface AppEventSourceInterface
{
    public function subscribe(AppEventHandlerInterface $handler): void;

    public function unsubscribe(AppEventHandlerInterface $handler): void;
}