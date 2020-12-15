<?php

namespace App\Module\User\Domain\Service;

use App\Module\User\App\Data\UserData;
use App\Module\User\Domain\Exception\DuplicateUserEmailException;
use App\Module\User\Domain\Exception\DuplicateUsernameException;
use App\Module\User\Domain\Exception\UnknownUserGradeException;
use App\Module\User\Domain\Exception\UserByIdNotFoundException;
use App\Module\User\Domain\Model\Mapper\UserMapper;
use App\Module\User\Domain\Model\User;
use App\Module\User\Domain\Model\UserGrade;
use App\Module\User\Domain\Model\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(int $userId): ?UserData
    {
        $user = $this->userRepository->findById($userId);

        if ($user === null)
        {
            return null;
        }

        return UserMapper::getUserData($user);
    }

    public function getUserByEmail(string $email): ?UserData
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null)
        {
            return null;
        }

        return UserMapper::getUserData($user);
    }

    /**
     * @param string $email
     * @param string $username
     * @param string $password
     * @param int $grade
     * @return User
     * @throws DuplicateUserEmailException
     * @throws DuplicateUsernameException
     * @throws UnknownUserGradeException
     */
    public function addUser(string $email, string $username, string $password, int $grade): User
    {
        $this->assertGradeCorrect($grade);

        $this->assertNoDuplicateEmail($email);
        $this->assertNoDuplicateUsername($username);


        $user = new User(
            null,
            $username,
            $password,
            new \DateTimeImmutable(),
            $email,
            $grade
        );

        $this->userRepository->add($user);

        return $user;
    }

    /**
     * @param int $userId
     * @param string|null $newEmail
     * @param string|null $newUsername
     * @param string|null $newPassword
     * @param int|null $newGrade
     * @throws DuplicateUserEmailException
     * @throws DuplicateUsernameException
     * @throws UnknownUserGradeException
     * @throws UserByIdNotFoundException
     */
    public function editUser(int $userId, ?string $newEmail, ?string $newUsername, ?string $newPassword, ?int $newGrade): void
    {
        $user = $this->userRepository->findById($userId);

        if ($user === null)
        {
            throw new UserByIdNotFoundException('', ['user_id' => $userId]);
        }

        if ($newGrade !== null && $user->getGrade() !== $newGrade)
        {
            $this->assertGradeCorrect($newGrade);
            $user->setGrade($newGrade);
        }

        if ($newEmail !== null && $user->getEmail() !== $newEmail)
        {
            $this->assertNoDuplicateEmail($newEmail);
            $user->setEmail($newEmail);
        }

        if ($newPassword !== null && $user->getPassword() !== $newPassword)
        {
            $user->setPassword($newPassword);
        }

        if ($newUsername !== null && $user->getUsername() !== $newUsername)
        {
            $this->assertNoDuplicateUsername($newUsername);
            $user->setUsername($newUsername);
        }
    }

    /**
     * @param string $email
     * @throws DuplicateUserEmailException
     */
    private function assertNoDuplicateEmail(string $email): void
    {
        if ($this->userRepository->findByEmail($email) !== null)
        {
            throw new DuplicateUserEmailException('', ['email' => $email]);
        }
    }

    /**
     * @param string $username
     * @throws DuplicateUsernameException
     */
    private function assertNoDuplicateUsername(string $username): void
    {
        if ($this->userRepository->findByUsername($username) !== null)
        {
            throw new DuplicateUsernameException('', ['username' => $username]);
        }
    }

    /**
     * @param int $grade
     * @throws UnknownUserGradeException
     */
    private function assertGradeCorrect(int $grade): void
    {
        if (!UserGrade::exists($grade))
        {
            throw new UnknownUserGradeException('', ['grade_level' => $grade]);
        }
    }
}