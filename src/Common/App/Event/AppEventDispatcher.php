<?php

namespace App\Common\App\Event;

use App\Common\Domain\Utils\Arrays;

class AppEventDispatcher implements AppEventDispatcherInterface, AppEventSourceInterface
{
    /** @var AppEventHandlerInterface[] */
    private array $handlers = [];

    public function dispatch(AppEventInterface $event): void
    {
        foreach ($this->handlers as $handler)
        {
            $handler->handle($event);
        }
    }

    public function subscribe(AppEventHandlerInterface $handler): void
    {
        $this->handlers[spl_object_hash($handler)] = $handler;
    }

    public function unsubscribe(AppEventHandlerInterface $handler): void
    {
        Arrays::removeByKey($this->handlers, spl_object_hash($handler));
    }
}