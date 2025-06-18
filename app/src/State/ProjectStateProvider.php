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
        private readonly ProviderInterface $collectionProvider,
        private readonly ProviderInterface $itemProvider,
        // private readonly RateLimiterFactoryInterface $apiLimiter
        #[Autowire(service: 'limiter.anonymous_api')]
        private readonly RateLimiterFactoryInterface $apiLimiter,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        //get Client request
        $request = $context['request'];
        $limiter = $this->apiLimiter->create($request->getClientIp());

        if (false === $limiter->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException();
        }

        // Check if the operation is a collection operation
        if($operation instanceof GetCollection) {
            return $this->collectionProvider->provide($operation, $uriVariables, $context);
        }
        return $this->itemProvider->provide($operation, $uriVariables, $context);
    }
}
