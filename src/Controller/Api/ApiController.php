<?php

namespace App\Controller\Api;

use App\Common\App\View\RenderableViewInterface;
use App\Controller\Api\Exception\NoLoggedUserException;
use App\Framework\Infrastructure\Security\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    protected function renderableJson($data, int $status = 200, array $headers = [], array $context = []): RenderableViewInterface
    {
        $response = $this->json($data, $status, $headers, $context);

        return new class($response) implements RenderableViewInterface {
            protected Response $response;

            public function __construct(Response $response)
            {
                $this->response = $response;
            }

            public function render(): Response
            {
                return $this->response;
            }
        };
    }
}