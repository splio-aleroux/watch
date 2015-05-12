<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Splio\WatchBundle\Entity\LinkRepository;

class LinkService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

    public function getByUser(User $user, $offset = 0, $limit= 10)
    {

    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
    }

}
