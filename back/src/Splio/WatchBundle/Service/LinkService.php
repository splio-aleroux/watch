<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Splio\WatchBundle\Entity\LinkRepository;

class LinkService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

    /**
     * [getByUser description]
     * @param  User    $user   [description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]          [description]
     */
    public function getByUser(User $user, $offset = 0, $limit= 10)
    {
        $links = $this->linkRepository->findBy(
            ['user' => $user],
            null,
            $limit,
            $offset
        );
        return $links;
    }

    /**
     * [getByTag description]
     * @param  Tag     $tag    [description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]          [description]
     */
    public function getByTag(Tag $tag, $offset = 0, $limit= 10)
    {
        $links = $this->linkRepository->findBy(
            ['tags' => $tag],
            null,
            $limit,
            $offset
        );

        return $links;
    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
    }
}
