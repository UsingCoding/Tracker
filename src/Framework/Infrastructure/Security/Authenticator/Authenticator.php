<?php


namespace App\Framework\Infrastructure\Security\Authenticator;


use App\Framework\Infrastructure\Security\User\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class Authenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    private const SUPPORTED_ROUTE = 'api_auth';

    public function supports(Request $request): ?bool
    {
        return $request->get('_route') === self::SUPPORTED_ROUTE;
    }

    public function authenticate(Request $request): PassportInterface
    {
        $user = new User();

        return new Passport($user, new CustomCredentials(
            function ($credentials, UserInterface $user) {
                return $credentials === $user->getPassword();
            },
            '1234'
        ));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new JsonResponse(['isLogin' => 1]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['isLogin' => 0]);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
//        return new RedirectResponse($url);

        return new JsonResponse(['redirected' => 1]);
    }
}