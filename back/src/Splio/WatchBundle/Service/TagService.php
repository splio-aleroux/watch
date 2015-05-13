<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\Tag;
use Splio\WatchBundle\Entity\LinkRepository;

class TagService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

    public function getLinks(Tag $tag, $offset = 0, $limit = 10)
    {
        $links = $this->linkRepository->getTagLinks($tag, $offset, $limit);

        return $links;
    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
    }
}
