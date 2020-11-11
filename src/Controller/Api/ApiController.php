<?php

namespace App\Controller\Api;

use App\Controller\Api\Exception\NoLoggedUserException;
use App\Framework\Infrastructure\Security\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

abstract class ApiController extends AbstractController
{
    /**
     * @return User
     * @throws NoLoggedUserException
     */
    public function getLoggedUser(): User
    {
        $user = $this->getUser();

        if (!$user instanceof User)
        {
            throw new NoLoggedUserException();
        }

        return $user;
    }

    public function __invoke(): Response
    {
        return new Response('REST');
    }
}