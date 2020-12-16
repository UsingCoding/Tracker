<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiController;
use App\Module\User\Api\ApiInterface;
use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Input\AddUserInput;
use App\Module\User\Api\Input\EditUserInput;
use App\View\UserListView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    /**
     * @param Request $request
     * @param ApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function addUser(Request $request, ApiInterface $api): Response
    {
        try
        {
            $api->addUser(new AddUserInput(
                $request->get('email'),
                $request->get('username'),
                $request->get('password'),
                $request->get('grade')
            ));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::DUPLICATE_EMAIL)
            {
                return $this->json(['error' => 'duplicate_email']);
            }

            if ($exception->getType() === ApiException::DUPLICATE_USERNAME)
            {
                return $this->json(['error' => 'duplicate_username']);
            }

            if ($exception->getType() === ApiException::UNKNOWN_GRADE)
            {
                return $this->json(['error' => 'unknown_grade']);
            }

            if ($exception->getType() === ApiException::INVALID_USER_DATA)
            {
                return $this->json(['error' => 'invalid_user_data']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param ApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function editUser(Request $request, ApiInterface $api): Response
    {
        try
        {
            $api->editUser(new EditUserInput(
                $request->get('user_id'),
                $request->get('email'),
                $request->get('username'),
                $request->get('password'),
                $request->get('grade')
            ));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::DUPLICATE_EMAIL)
            {
                return $this->json(['error' => 'duplicate_email']);
            }

            if ($exception->getType() === ApiException::DUPLICATE_USERNAME)
            {
                return $this->json(['error' => 'duplicate_username']);
            }

            if ($exception->getType() === ApiException::UNKNOWN_GRADE)
            {
                return $this->json(['error' => 'unknown_grade']);
            }

            if ($exception->getType() === ApiException::USER_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'user_not_found']);
            }

            if ($exception->getType() === ApiException::INVALID_USER_DATA)
            {
                return $this->json(['error' => 'invalid_user_data']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param ApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function deleteUser(Request $request, ApiInterface $api): Response
    {
        try
        {
            $api->deleteUser($request->get('user_id'));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::USER_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'user_not_found']);
            }

            throw $exception;
        }
    }

    /**
     * @param ApiInterface $api
     * @return Response
     * @throws ApiException
     */
    public function list(ApiInterface $api): Response
    {
        $list = $api->list();

        $view = new UserListView($list);

        return $view->render();
    }
}