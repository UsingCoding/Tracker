<?php

namespace App\Framework\Infrastructure\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonRequestListener implements EventSubscriberInterface
{
    private const JSON_CONTENT_HEADER = 'application/json';
    private const CONTENT_TYPE_KEY = 'Content-Type';

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (0 !== strpos($request->headers->get(self::CONTENT_TYPE_KEY), self::JSON_CONTENT_HEADER))
        {
            $this->logger->debug('Json response parsing skipped');
            return;
        }

        try
        {
            $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        }
        catch (\JsonException $e)
        {
            $this->logger->error('Failed to parse json request', ['ex' => $e]);
            return;
        }

        $request->request->replace($content);

        $this->logger->debug('Parsed json request body');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 4]
        ];
    }
}