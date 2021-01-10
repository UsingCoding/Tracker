<?php

namespace App\Framework\Infrastructure\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutRedirectListener implements EventSubscriberInterface
{
    private const LOGIN_ROUTE = 'frontend_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onLogout(LogoutEvent $event): void
    {
        $response = new RedirectResponse($this->urlGenerator->generate(self::LOGIN_ROUTE));

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogout'
        ];
    }
}