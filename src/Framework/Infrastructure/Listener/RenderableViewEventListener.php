<?php

namespace App\Framework\Infrastructure\Listener;

use App\Common\App\View\RenderableViewInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RenderableViewEventListener implements EventSubscriberInterface
{
    public function onKernelView(ViewEvent $event): void
    {
        /** @var RenderableViewInterface|mixed $view */
        $view = $event->getControllerResult();

        if (!$view instanceof RenderableViewInterface)
        {
            return;
        }

        $event->setResponse($view->render());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 4]
        ];
    }
}