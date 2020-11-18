<?php

namespace App\Controller\Api\Issue;

use App\Controller\Api\ApiController;
use App\Module\Issue\Api\ApiInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\CreateIssueInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IssueManagementController extends ApiController
{
    /**
     * @param Request $request
     * @param ApiInterface $issueApi
     * @return Response
     * @throws ApiException
     */
    public function createIssue(Request $request, ApiInterface $issueApi): Response
    {
        try
        {
            $issueId = $issueApi->createIssue(new CreateIssueInput(
                $request->get('name'),
                $request->get('description'),
                $request->get('fields')
            ));

            return new JsonResponse(['issue_id' => $issueId]);
        }
        catch (ApiException $exception)
        {
            throw $exception;
        }
    }
}