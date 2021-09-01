<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method UserInterface loadUserByIdentifier(string $identifier)
 */
class ChefFormationProvider implements \Symfony\Component\Security\Core\User\UserProviderInterface, \Symfony\Component\Security\Core\User\PasswordUpgraderInterface
{

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        // TODO: Implement supportsClass() method.
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username)
    {
        // TODO: Implement loadUserByUsername() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method UserInterface loadUserByIdentifier(string $identifier)
    }
}