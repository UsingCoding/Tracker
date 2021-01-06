<?php

namespace App\Controller\Api\Project;

use App\Common\App\View\RenderableViewInterface;
use App\Controller\Api\ApiController;
use App\Controller\Api\Exception\NoLoggedUserException;
use App\Module\Project\Api\ApiInterface;
use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\AddTeamMemberInput;
use App\Module\Project\Api\TeamApiInterface;
use App\View\TeamMemberListView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends ApiController
{
    /**
     * @param Request $request
     * @param TeamApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function addMember(Request $request, TeamApiInterface $api): Response
    {
        try
        {
            $api->addMember(new AddTeamMemberInput(
                $request->get('project_id'),
                $request->get('user_id')
            ));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::USER_TO_ADD_TO_TEAM_NOT_FOUND)
            {
                return $this->json(['error' => 'user_not_found']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param TeamApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function removeMember(Request $request, TeamApiInterface $api): Response
    {
        try
        {
            $api->removeMember($request->get('team_member_id'));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::TEAM_MEMBER_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'team_member_not_found']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param ApiInterface $projectApi
     * @return RenderableViewInterface
     * @throws ApiException
     * @throws NoLoggedUserException
     */
    public function list(Request $request, ApiInterface $projectApi): RenderableViewInterface
    {
        $projectId = $request->get('project_id');

        $list = $projectApi->teamMemberList($projectId);
        $project = $projectApi->getProject($projectId);

        return new TeamMemberListView($list, $project, $this->getLoggedUser());
    }
}