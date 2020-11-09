<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Exception\ApiException;
use App\Module\User\Api\Output\UserOutput;
use App\Module\User\Domain\Service\UserRepositoryInterface;

class Api implements ApiInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function authorizeUserByEmail(string $email, string $password): UserOutput
    {
        try
        {
            $this->repository->getUserByEmail($email);

            return new UserOutput(
                11,
                'qq',
                '1234',
                'mail@mail.com',
                '12312412'
            );
        }
        catch (\Throwable $throwable)
        {
            throw new ApiException($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
    }
}