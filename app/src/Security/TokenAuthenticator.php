<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\Security\TokenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class TokenAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenService $jwt
    )
    {
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization') && \str_contains((string) $request->headers->get('Authorization'), 'Bearer ');
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = \str_replace('Bearer ', '', (string) $request->headers->get('Authorization'));
        $payload = $this->jwt->getPayload($apiToken);
        return new SelfValidatingPassport(new UserBadge($payload->user_id, function ($uid) {
            $user = $this->userRepository->findOneBy(['username' => $uid]);

            return $user ?: '';
        }));
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ): ?Response {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): ?Response {
        return new JsonResponse([
            'message' => 'Authentication Required',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
