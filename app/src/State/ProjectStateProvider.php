<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\RateLimiter\RateLimiterFactoryInterface;

class ProjectStateProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $collectionProvider,
        private readonly ProviderInterface $itemProvider,
        // private readonly RateLimiterFactoryInterface $apiLimiter
        #[Autowire(service: 'rate_limiter')]
        private readonly RateLimiterFactoryInterface $apiLimiter,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        dd($this->apiLimiter);
        $limiter = $this->apiLimiter->create($request->getClientIp());
        dd($limiter);
        $tmp = $this->collectionProvider->provide($operation, $uriVariables, $context);
        return $tmp;
    }
}