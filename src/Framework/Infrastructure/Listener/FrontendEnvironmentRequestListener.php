<?php

namespace App\Framework\Infrastructure\Listener;

use App\Common\Domain\Utils\Strings;
use App\Controller\Frontend\FrontendController;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FrontendEnvironmentRequestListener implements EventSubscriberInterface
{
    private const CONTROLLER_ATTRIBUTE_KEY = '_controller';
    private const ROUTE__ATTRIBUTE_KEY = '_route';
    private const FRONTEND_PREFIX = 'frontend';

    private LoggerInterface $logger;
    private string $defaultFrontendControllerClass;

    public function __construct(LoggerInterface $logger, string $defaultFrontendControllerClass = '')
    {
        $this->logger = $logger;
        $this->defaultFrontendControllerClass = $defaultFrontendControllerClass;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMasterRequest())
        {
            return;
        }

        $request = $event->getRequest();

        if (!$this->isFrontendRequest($request))
        {
            return;
        }

        if ($request->attributes->has(self::CONTROLLER_ATTRIBUTE_KEY))
        {
            return;
        }

        $this->logger->debug('Default frontend controller was set for request', ['uri' => $request->getUri()]);

        $request->attributes->set(self::CONTROLLER_ATTRIBUTE_KEY, $this->defaultFrontendControllerClass);
    }

    private function isFrontendRequest(Request $request): bool
    {
        return Strings::isStartsWith($request->get(self::ROUTE__ATTRIBUTE_KEY) ?? '', self::FRONTEND_PREFIX);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 6]
        ];
    }
}