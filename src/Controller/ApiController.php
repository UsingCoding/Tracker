<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends AbstractController
{
    public function response(array $data): Response
    {
        return new JsonResponse($data);
    }

    public function __invoke(): Response
    {
        return new Response('REST');
    }
}