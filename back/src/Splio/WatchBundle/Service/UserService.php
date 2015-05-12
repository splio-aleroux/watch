<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    // Create user
    public function create(array $arguments){
        $user = new User();

        foreach ($arguments as $propertyName => $value) {
            $method = 'set' . ucfirst($propertyName);
            $user->$method($value);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response ($user->getId());
    }

    // Delete user
    // Update user
    // Sign in
    // Sign out
    // current state
    // Get links
    // Add link
    // Remove link
}
