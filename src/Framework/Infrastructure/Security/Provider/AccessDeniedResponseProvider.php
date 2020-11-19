<?php

namespace App\Framework\Infrastructure\Security\Provider;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedResponseProvider implements AccessDeniedResponseProviderInterface
{
    public function getResponse(): Response
    {
        return new JsonResponse(['error' => 'access_denied'], 403);
    }
}