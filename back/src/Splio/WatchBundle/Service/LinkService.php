<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Splio\WatchBundle\Entity\TagRepository;

class LinkService
{
    /**
     * @var TagRepository
     */
    protected $tagRepository;


    public function getTags(Link $link, $offset = 0, $limit= 10)
    {
        $tags = $this->tagRepository->findTagsOfLink($link, $offset = 0, $limit = 10);

        return $tags;
    }


    public function setTagRepository(TagRepository $repository)
    {
        $this->tagRepository = $repository;
    }
}
