<?php

namespace App\State;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactoryInterface;

class ProjectStateProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,
        #[Autowire(service: 'limiter.anonymous_api')]
        private readonly RateLimiterFactoryInterface $anonymousApi
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $request = $context['request'];

        $limiter = $this->anonymousApi->create($request->getClientIp());

        if(false === $limiter->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException();
        }

        if ($operation instanceof GetCollection) {
           return $this->collectionProvider->provide($operation, $uriVariables, $context);
        }
        return $this->itemProvider->provide($operation, $uriVariables, $context);
    }
}
