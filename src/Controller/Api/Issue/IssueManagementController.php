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
            if ($exception->getType() === ApiException::PROJECT_TO_ADD_ISSUE_NOT_EXISTS)
            {
                return $this->json(['error' => 'project_not_exists']);
            }

            if ($exception->getType() === ApiException::USER_TO_ASSIGNEE_ISSUE_NOT_EXISTS)
            {
                return $this->json(['error' => 'user_not_exists']);
            }

            throw $exception;
        }
    }

    /**
     * @param string $issueCode
     * @param ApiInterface $issueApi
     * @return Response
     * @throws ApiException
     */
    public function getIssue(string $issueCode, ApiInterface $issueApi): Response
    {
        try
        {
            $issue = $issueApi->getIssue($issueCode);

            if ($issue === null)
            {
                return $this->json(['message' => 'issue_not_found'], 404);
            }

            return $this->json([
                'name' => $issue->getName(),
                'description' => $issue->getDescription(),
                'created_at' => $issue->getCreatedAt(),
                'updated_at' => $issue->getUpdatedAt()
            ]);
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::INVALID_ISSUE_CODE)
            {
                return $this->json(['message' => 'invalid_issue_code']);
            }

            throw $exception;
        }
    }
}