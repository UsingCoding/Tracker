<?php

namespace App\Framework\Infrastructure\Security\Authenticator;

use App\Framework\Infrastructure\Security\Provider\AccessDeniedResponseProviderInterface;
use App\Framework\Infrastructure\Security\User\User;
use App\Module\User\Api\ApiInterface as UserApi;
use App\Module\User\Api\Exception\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class Authenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    private const SUPPORTED_ROUTE = 'api_auth';

    private const USERNAME_OR_EMAIL_KEY = 'username';
    private const PASSWORD_KEY = 'password';

    private UserApi $api;
    private AccessDeniedResponseProviderInterface $responseProvider;

    public function __construct(UserApi $api, AccessDeniedResponseProviderInterface $responseProvider)
    {
        $this->api = $api;
        $this->responseProvider = $responseProvider;
    }

    public function supports(Request $request): ?bool
    {
        return $request->get('_route') === self::SUPPORTED_ROUTE;
    }

    public function authenticate(Request $request): PassportInterface
    {
        try
        {
            $user = new User($this->api->authorizeUserByEmail(
                $request->get(self::USERNAME_OR_EMAIL_KEY),
                $request->get(self::PASSWORD_KEY)
            ));

            return new SelfValidatingPassport($user);
        }
        catch (ApiException $exception)
        {
            throw new AuthenticationException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new JsonResponse(['isLogin' => 1]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['isLogin' => 0], 403);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return $this->responseProvider->getResponse();
    }
}