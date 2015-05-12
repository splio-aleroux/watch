<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Splio\WatchBundle\Entity\LinkRepository;

class TagService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

    public function getLinks(Tag $tag, $offset = 0, $limit= 10)
    {
        $links = $this->linkRepository->findLinksOfTag($tag, $offset = 0, $limit = 10);

        return $links;
    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
    }
}
