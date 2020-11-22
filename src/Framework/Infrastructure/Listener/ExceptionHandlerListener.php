<?php

namespace App\Framework\Infrastructure\Listener;

use App\Common\App\Exception\AbstractContextException;
use App\Common\Domain\Utils\Arrays;
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

        $exception = $event->getThrowable();

        $contextException = $this->findContextException($exception);

        if ($contextException === null)
        {
            return;
        }

        $event->setResponse(new JsonResponse(Arrays::merge(['error' => 'internal'], $contextException->getContext()), 500));
    }

    private function findContextException(\Throwable $throwable): ?AbstractContextException
    {
        $previous = $throwable->getPrevious();

        if ($previous === null)
        {
            return null;
        }

        if ($previous instanceof AbstractContextException && $previous->getContext() !== null)
        {
            return $previous;
        }

        return $this->findContextException($previous);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 5]
        ];
    }
}