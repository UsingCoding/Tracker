<?php

namespace App\Common\App\View;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait RenderableTrait
{
    public function json($data = null, int $status = 200, array $headers = [], bool $json = false): Response
    {
        return new JsonResponse($data, $status, $headers, $json);
    }
}