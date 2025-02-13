<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class LocaleLanguageSubscriber implements EventSubscriberInterface
{
    private RequestStack $requestStack;
    private string $defaultLocale;

    public function __construct(RequestStack $requestStack, string $defaultLocale = 'en')
    {
        $this->requestStack = $requestStack;
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $this->requestStack->getSession();

        if ($session && $session->has('_locale')) {
            $request->setLocale($session->get('_locale'));
        } else {
            $request->setLocale($this->defaultLocale);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
