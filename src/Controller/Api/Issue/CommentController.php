<?php

namespace App\Controller\Api\Issue;

use App\Controller\Api\ApiController;
use App\Module\Issue\Api\CommentApiInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddCommentInput;
use App\Module\Issue\Api\Input\EditCommentInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends ApiController
{
    /**
     * @param Request $request
     * @param CommentApiInterface $commentApi
     * @return Response
     * @throws ApiException
     */
    public function addComment(Request $request, CommentApiInterface $commentApi): Response
    {
        try
        {
            $commentId = $commentApi->addComment(new AddCommentInput(
                $request->get('issue_id'),
                $request->get('user_id'),
                $request->get('content')
            ));

            return $this->json(['comment_id' => $commentId]);
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::USER_TO_ADD_COMMENT_NOT_EXISTS)
            {
                return $this->json(['error' => 'user_not_exists']);
            }

            if ($exception->getType() === ApiException::ISSUE_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'issue_not_exists']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param CommentApiInterface $commentApi
     * @return Response
     * @throws ApiException
     */
    public function editComment(Request $request, CommentApiInterface $commentApi): Response
    {
        try
        {
            $commentApi->editComment(new EditCommentInput(
                $request->get('comment_id'),
                $request->get('content')
            ));

            return new Response('');
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::COMMENT_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'comment_not_found']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param CommentApiInterface $commentApi
     * @return Response
     * @throws ApiException
     */
    public function deleteComment(Request $request, CommentApiInterface $commentApi): Response
    {
        try
        {
            $commentApi->deleteComment($request->get('comment_id'));

            return new Response('');
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::COMMENT_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'comment_not_found']);
            }

            throw $exception;
        }
    }
}