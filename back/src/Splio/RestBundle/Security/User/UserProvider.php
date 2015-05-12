<?php

namespace Splio\RestBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class UserProvider implements UserProviderInterface
{
    /**
     *
     */
    protected $userRepository;

    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->findOneByPublicKey($username);
        // supposons qu'il retourne un tableau en cas de succès, ou bien
        // « false » s'il n'y a pas d'utilisateur

        if ($user) {
            return $user;
        }

        throw new UsernameNotFoundException(sprintf('Public key "%s" does not exist.', $username));
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getPublicKey());
    }

    public function supportsClass($class)
    {
        return $class === 'Splio\RestBundle\Security\User\UserProvider';
    }

    public function setUserRepository(EntityRepository $repository)
    {
        $this->userRepository = $repository;
    }
}