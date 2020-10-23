<?php


namespace App\Framework\Infrastructure\Security\User;


use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return '1234';
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return "Session User";
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }
}