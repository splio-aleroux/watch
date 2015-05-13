<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Command;
use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Entity\LinkRepository;
use Splio\WatchBundle\Entity\TagRepository;
use Splio\WatchBundle\Entity\UserRepository;

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
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param  UserCreateCommand $command
     * @return User     the user
     */
    public function create(Command\UserCreateCommand $command)
    {
        $user = new User();
        $user->setCreatedAt(new \DateTime());
        $user->setEmail($command->email);

        $this->userRepository->save($user);
        $command->setUser($user);
    }

    public function get($id)
    {
        $user = $this->userRepository->find($id);

        return $user;
    }

    public function count()
    {
        $count = $this->userRepository->count();

        return $count;
    }

    public function getUsers($offset = 0, $limit = 10)
    {
        $users = $this->userRepository->get($offset, $limit);

        return $users;
    }

    public function getByEmail($email)
    {
        $user = $this->userRepository->getByEmail($email);

        return $user;
    }

    public function getBySecretKey($secretKey)
    {
        $user = $this->userRepository->getBySecretKey($secretKey);

        return $user;
    }

    /**
     * [getLinks description]
     * @param  User    $user   [description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]  [description]
     */
    public function getLinks(User $user, $offset = 0, $limit = 10)
    {
        $links = $this->linkRepository->getUserLinks($user, $offset, $limit);

        return $links;
    }

    public function countLinks(User $user)
    {
        $count = $this->linkRepository->countUserLinks($user);

        return $count;
    }

    public function getTags(User $user, $offset = 0, $limit = 10)
    {
        $tags = $this->tagRepository->getUserTags($user, $offset, $limit);

        return $tags;
    }

    public function countTags(User $user)
    {
        $count = $this->tagRepository->countUserTags($user);

        return $count;
    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
    }

    public function setTagRepository(TagRepository $repository)
    {
        $this->tagRepository = $repository;
    }

    public function setUserRepository(UserRepository $repository)
    {
        $this->userRepository = $repository;
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
