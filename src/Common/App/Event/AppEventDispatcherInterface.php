<?php

namespace App\Common\App\Event;

interface AppEventDispatcherInterface
{
    public function dispatch(AppEventInterface $event): void;
}