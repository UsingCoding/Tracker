<?php


namespace App\Framework\Infrastructure\Security\User;


use App\Module\User\Api\Output\UserOutput;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private UserOutput $userOutput;

    public function __construct(UserOutput $userOutput)
    {
        $this->userOutput = $userOutput;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): string
    {
        return $this->userOutput->getPassword();
    }

    /**
     * @inheritDoc
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return $this->userOutput->getUsername();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {

    }
}