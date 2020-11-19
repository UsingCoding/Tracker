<?php

namespace App\Framework\Infrastructure\Security\Handler;

use App\Framework\Infrastructure\Security\Provider\AccessDeniedResponseProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private AccessDeniedResponseProviderInterface $responseProvider;

    public function __construct(AccessDeniedResponseProviderInterface $responseProvider)
    {
        $this->responseProvider = $responseProvider;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        return $this->responseProvider->getResponse();
    }
}