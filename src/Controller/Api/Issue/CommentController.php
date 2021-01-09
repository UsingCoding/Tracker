<?php

namespace App\Controller\Api\Issue;

use App\Common\App\View\RenderableViewInterface;
use App\Common\Infrastructure\Context\AvatarUrlProvider;
use App\Controller\Api\ApiController;
use App\Controller\Api\Exception\NoLoggedUserException;
use App\Module\Issue\Api\CommentApiInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddCommentInput;
use App\Module\Issue\Api\Input\EditCommentInput;
use App\View\CommentsListView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends ApiController
{
    /**
     * @param Request $request
     * @param CommentApiInterface $commentApi
     * @return Response
     * @throws ApiException
     * @throws NoLoggedUserException
     */
    public function addComment(Request $request, CommentApiInterface $commentApi): Response
    {
        try
        {
            $commentId = $commentApi->addComment(new AddCommentInput(
                $request->get('issue_id'),
                $this->getLoggedUser()->getUserOutput()->getUserId(),
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

    /**
     * @param Request $request
     * @param CommentApiInterface $commentApi
     * @param AvatarUrlProvider $avatarUrlProvider
     * @return RenderableViewInterface
     * @throws ApiException
     */
    public function commentsForIssue(Request $request, CommentApiInterface $commentApi, AvatarUrlProvider $avatarUrlProvider): RenderableViewInterface
    {
        $comments = $commentApi->commentsForIssue($request->get('issue_id'));

        return new CommentsListView($comments, $avatarUrlProvider);
    }
}