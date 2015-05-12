<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Entity\LinkRepository;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

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

    /**
     * [getLinks description]
     * @param  User    $user   [description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]          [description]
     */
    public function getLinks(User $user, $offset = 0, $limit = 10)
    {
        $links = $this->linkRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            $limit,
            $offset
        );
        return $links;
    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
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
