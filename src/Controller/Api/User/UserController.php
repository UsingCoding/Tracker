<?php

namespace App\Controller\Api\User;

use App\Common\App\Exception\CantStoreFileException;
use App\Common\App\View\RenderableViewInterface;
use App\Common\Infrastructure\Context\AvatarUrlProvider;
use App\Common\Infrastructure\Persistence\FileRepositoryInterface;
use App\Controller\Api\ApiController;
use App\Controller\Api\Exception\NoLoggedUserException;
use App\Module\Account\Api\ApiInterface as AccountApi;
use App\Module\Account\Api\Exception\ApiException as AccountApiException;
use App\Module\User\Api\ApiInterface as UserApi;
use App\Module\User\Api\Exception\ApiException as UserApiException;
use App\Module\User\Api\Input\AddUserInput;
use App\Module\User\Api\Input\EditUserInput;
use App\View\UserInfoView;
use App\View\UserListView;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    /**
     * @param Request $request
     * @param UserApi $api
     * @param FileRepositoryInterface $fileRepository
     * @return Response
     * @throws UserApiException
     * @throws CantStoreFileException
     */
    public function addUser(
        Request $request,
        UserApi $api,
        FileRepositoryInterface $fileRepository
    ): Response
    {
        try
        {
            /** @var string|null $avatarUrl */
            $avatarUrl = null;

            /** @var UploadedFile|null $file */
            $file = $request->files->get('avatar');

            if ($file !== null)
            {
                $avatarUrl = $fileRepository->store($file->getRealPath(), $file->getClientOriginalExtension());
            }

            $api->addUser(new AddUserInput(
                $request->get('email'),
                $request->get('username'),
                $request->get('password'),
                $request->get('grade'),
                $avatarUrl
            ));

            return new Response();
        }
        catch (UserApiException $exception)
        {
            if ($exception->getType() === UserApiException::DUPLICATE_EMAIL)
            {
                return $this->json(['error' => 'duplicate_email']);
            }

            if ($exception->getType() === UserApiException::DUPLICATE_USERNAME)
            {
                return $this->json(['error' => 'duplicate_username']);
            }

            if ($exception->getType() === UserApiException::UNKNOWN_GRADE)
            {
                return $this->json(['error' => 'unknown_grade']);
            }

            if ($exception->getType() === UserApiException::INVALID_USER_DATA)
            {
                return $this->json(['error' => 'invalid_user_data']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param UserApi $api
     * @param FileRepositoryInterface $fileRepository
     * @return Response
     * @throws UserApiException
     * @throws CantStoreFileException
     */
    public function editUser(Request $request, UserApi $api, FileRepositoryInterface $fileRepository): Response
    {
        try
        {
            /** @var string|null $avatarUrl */
            $avatarUrl = null;

            /** @var UploadedFile|null $file */
            $file = $request->files->get('avatar');

            if ($file !== null)
            {
                $avatarUrl = $fileRepository->store($file->getRealPath(), $file->getClientOriginalExtension());
            }

            $api->editUser(new EditUserInput(
                $request->get('user_id'),
                $request->get('email'),
                $request->get('username'),
                $request->get('password'),
                $request->get('grade'),
                $avatarUrl
            ));

            return new Response();
        }
        catch (UserApiException $exception)
        {
            if ($exception->getType() === UserApiException::DUPLICATE_EMAIL)
            {
                return $this->json(['error' => 'duplicate_email']);
            }

            if ($exception->getType() === UserApiException::DUPLICATE_USERNAME)
            {
                return $this->json(['error' => 'duplicate_username']);
            }

            if ($exception->getType() === UserApiException::UNKNOWN_GRADE)
            {
                return $this->json(['error' => 'unknown_grade']);
            }

            if ($exception->getType() === UserApiException::USER_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'user_not_found']);
            }

            if ($exception->getType() === UserApiException::INVALID_USER_DATA)
            {
                return $this->json(['error' => 'invalid_user_data']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param UserApi $api
     * @return Response
     * @throws UserApiException
     */
    public function deleteUser(Request $request, UserApi $api): Response
    {
        try
        {
            $api->deleteUser($request->get('user_id'));

            return new Response();
        }
        catch (UserApiException $exception)
        {
            if ($exception->getType() === UserApiException::USER_BY_ID_NOT_FOUND)
            {
                return $this->json(['error' => 'user_not_found']);
            }

            if ($exception->getType() === UserApiException::USER_CANT_DELETE_HIM_SELF)
            {
                return $this->json(['error' => 'user_cant_delete_him_self']);
            }

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param UserApi $api
     * @param AvatarUrlProvider $avatarUrlProvider
     * @return RenderableViewInterface
     * @throws UserApiException
     */
    public function user(Request $request, UserApi $api, AvatarUrlProvider $avatarUrlProvider): RenderableViewInterface
    {
        try
        {
            $user = $api->getUserById($request->get('user_id'));

            return new UserInfoView($user, $avatarUrlProvider);
        }
        catch (UserApiException $exception)
        {
            if ($exception->getType() === UserApiException::USER_BY_ID_NOT_FOUND)
            {
                return $this->renderableJson(['error' => 'user_by_id_not_found']);
            }

            throw $exception;
        }
    }

    /**
     * @param UserApi $userApi
     * @param AccountApi $accountApi
     * @return RenderableViewInterface
     * @throws UserApiException
     * @throws NoLoggedUserException
     * @throws AccountApiException
     */
    public function list(UserApi $userApi, AccountApi $accountApi): RenderableViewInterface
    {
        $list = $userApi->list();
        $account = $accountApi->getAccount();

        return new UserListView($list, $account, $this->getLoggedUser());
    }
}