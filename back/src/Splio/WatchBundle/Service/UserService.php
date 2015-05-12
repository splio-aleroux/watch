<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Entity\LinkRepository;
use Splio\WatchBundle\Entity\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Orm\EntityManager;

class UserService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    // Create user
    public function create(array $arguments){
        $user = new User();
        $user->setCreatedAt(new \DateTime());

        foreach ($arguments as $propertyName => $value) {
            $method = 'set' . ucfirst($propertyName);
            $user->$method($value);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
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

    public function getTags(User $user, $offset = 0, $limit = 10)
    {
        $tags = $this->tagRepository->findTagsOfUser($user, $offset, $limit);

        return $tags;
    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
    }

    public function setTagRepository(TagRepository $repository)
    {
        $this->tagRepository = $repository;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
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
