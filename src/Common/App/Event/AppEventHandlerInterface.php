<?php

namespace App\Common\App\Event;

interface AppEventHandlerInterface
{
    public function handle(AppEventInterface $event): void;
}