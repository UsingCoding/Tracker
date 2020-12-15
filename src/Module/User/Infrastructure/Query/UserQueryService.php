<?php

namespace App\Module\User\Infrastructure\Query;

use App\Module\User\App\Data\UserData;
use App\Module\User\App\Exception\UserNotFoundException;
use App\Module\User\App\Query\UserQueryServiceInterface;
use App\Module\User\Domain\Model\Mapper\UserMapper;
use App\Module\User\Domain\Model\UserRepositoryInterface;
use App\Module\User\Infrastructure\Hydration\UserDataHydrator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class UserQueryService implements UserQueryServiceInterface
{
    private UserRepositoryInterface $userRepo;
    private Connection $connection;

    public function __construct(UserRepositoryInterface $userRepo, Connection $connection)
    {
        $this->userRepo = $userRepo;
        $this->connection = $connection;
    }

    public function getUserById(int $userId): UserData
    {
        $user = $this->userRepo->findById($userId);

        if ($user === null)
        {
            throw new UserNotFoundException('', ['userId' => $userId]);
        }

        return UserMapper::getUserData($user);
    }

    public function getUserByUsername(string $username): UserData
    {
        $user = $this->userRepo->findByUsername($username);

        if ($user === null)
        {
            throw new UserNotFoundException('', ['username' => $username]);
        }

        return UserMapper::getUserData($user);
    }

    public function getList(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->addSelect('u.user_id')
            ->addSelect('u.username')
            ->addSelect('u.password')
            ->addSelect('u.created_at')
            ->addSelect('u.email')
            ->addSelect('u.grade')
            ->from('account_user', 'u')
        ;

        $stmt = $queryBuilder->execute();
        $row = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        $stmt->closeCursor();

        if ($row === false)
        {
            return [];
        }

        $hydrator = new UserDataHydrator($this->connection->getDatabasePlatform());

        return $hydrator->hydrateAll($row);
    }
}