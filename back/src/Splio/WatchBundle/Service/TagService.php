<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\Tag;
use Splio\WatchBundle\Entity\LinkRepository;
use Splio\WatchBundle\Entity\TagRepository;

class TagService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

    /**
     * @var TagRepository
     */
    protected $tagRepository;

    public function getLinks(Tag $tag, $offset = 0, $limit = 10)
    {
        $links = $this->linkRepository->getTagLinks($tag, $offset, $limit);

        return $links;
    }

    public function getTags($offset = 0, $limit = 10)
    {
        $tags = $this->tagRepository->get($offset, $limit);

        return $tags;
    }

    public function get($id)
    {
        $tag = $this->tagRepository->find($id);

        return $tag;
    }

    public function setLinkRepository(LinkRepository $repository)
    {
        $this->linkRepository = $repository;
    }

    public function setTagRepository(TagRepository $repository)
    {
        $this->tagRepository = $repository;
    }
}
