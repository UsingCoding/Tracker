<?php

namespace App\Controller\Api\Issue;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Infrastructure\Context\AvatarUrlProvider;
use App\Controller\Api\ApiController;
use App\Module\Issue\Api\ApiInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\CreateIssueInput;
use App\Module\Issue\Api\Input\EditIssueInput;
use App\View\IssuesListView;
use App\View\IssueView;
use App\View\NewIssueView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IssueManagementController extends ApiController
{
    private const DEFAULT_PAGE = 1;

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
     * @param AvatarUrlProvider $avatarUrlProvider
     * @return Response
     * @throws ApiException
     */
    public function getIssue(string $issueCode, ApiInterface $issueApi, AvatarUrlProvider $avatarUrlProvider): Response
    {
        try
        {
            $issue = $issueApi->getIssue($issueCode);

            if ($issue === null)
            {
                return $this->json(['message' => 'issue_not_found'], 404);
            }

            $view = new IssueView($issue, $avatarUrlProvider);

            return $view->render();
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

    /**
     * @param Request $request
     * @param ApiInterface $issueApi
     * @return Response
     * @throws ApiException
     */
    public function editIssue(Request $request, ApiInterface $issueApi): Response
    {
        try
        {
            $issueApi->editIssue(new EditIssueInput(
                $request->get('issue_id'),
                $request->get('name'),
                $request->get('description'),
                $request->get('fields')
            ));

            return $this->json(['success' => 1]);
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::ISSUE_BY_ID_NOT_FOUND)
            {
                return $this->json(['message' => 'issue_not_found'], 404);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param ApiInterface $issueApi
     * @return Response
     * @throws ApiException
     */
    public function deleteIssue(Request $request, ApiInterface $issueApi): Response
    {
        try
        {
            $issueApi->deleteIssue($request->get('issue_id'));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::ISSUE_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'issue_not_found'], 404);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param ApiInterface $issueApi
     * @return Response
     * @throws ApiException
     */
    public function issuesList(Request $request, ApiInterface $issueApi): Response
    {
        $list = $issueApi->issuesList(
            $request->get('search_query'),
            $request->get('page', self::DEFAULT_PAGE),
            $request->get('project_id'),
        );

        $view = new IssuesListView($list);

        return $view->render();
    }

    /**
     * @param Request $request
     * @param ApiInterface $issueApi
     * @return RenderableViewInterface
     * @throws ApiException
     */
    public function newIssueView(Request $request, ApiInterface $issueApi): RenderableViewInterface
    {
        $fields = $issueApi->issueFieldListForProject($request->get('project_id'));

        return new NewIssueView($fields);
    }
}