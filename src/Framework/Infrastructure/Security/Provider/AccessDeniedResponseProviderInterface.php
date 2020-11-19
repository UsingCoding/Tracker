<?php

namespace App\Framework\Infrastructure\Security\Provider;

use Symfony\Component\HttpFoundation\Response;

interface AccessDeniedResponseProviderInterface
{
    public function getResponse(): Response;
}