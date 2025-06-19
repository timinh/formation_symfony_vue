<?php

namespace App\EventSubscriber;

use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\RateLimiter\RateLimiterFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class ApiRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        #[Autowire(service: 'limiter.anonymous_api')]
        private readonly RateLimiterFactoryInterface $anonymousApi)
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $limiter = $this->anonymousApi->create($event->getRequest()->getClientIp());

        if(false === $limiter->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException();
        }
    }
}