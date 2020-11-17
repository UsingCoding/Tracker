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

    /**
     * @param string $message
     * @param \Throwable|null $previous
     * @param string|null $returnUrl
     * @throws AccessDeniedException
     */
    protected function throwAccessDeniedException(string $message = 'Access Denied.', \Throwable $previous = null, ?string $returnUrl = null): void
    {
        $exception = $this->createAccessDeniedException($message, $previous);

        if ($returnUrl !== null)
        {
            $exception->setAttributes([
                'return_url' => $returnUrl
            ]);
        }

        throw $exception;
    }
}