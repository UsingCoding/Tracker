<?php

namespace App\Controller\Api\Assigment;

use App\Controller\Api\ApiController;
use App\Module\FuzzyIntegration\Api\ApiInterface;
use App\Module\FuzzyIntegration\Api\Exception\ApiException;
use App\Module\FuzzyIntegration\Api\Input\CalculateDeveloperLevelInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AssigmentController extends ApiController
{
    /**
     * @param ApiInterface $api
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function __invoke(ApiInterface $api, Request $request): Response
    {
        $level = $api->calculateDeveloperLevel(new CalculateDeveloperLevelInput(
            $request->get('difficulty'),
            $request->get('time')
        ));

        return $this->json(['level' => $level]);
    }
}