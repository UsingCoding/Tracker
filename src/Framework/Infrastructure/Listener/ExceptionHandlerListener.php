<?php

namespace App\Framework\Infrastructure\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionHandlerListener implements EventSubscriberInterface
{
    private bool $catch;
    private LoggerInterface $logger;

    public function __construct(bool $catch, LoggerInterface $logger)
    {
        $this->catch = $catch;
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$this->catch)
        {
            $this->logger->debug('Exception passed');
            return;
        }

        $event->setResponse(new JsonResponse(['error' => 'internal'], 500));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 5]
        ];
    }
}