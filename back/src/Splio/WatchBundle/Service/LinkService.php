<?php

namespace Splio\WatchBundle\Service;

use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Entity\TagRepository;
use Splio\WatchBundle\Entity\LinkRepository;

class LinkService
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;

    /**
     * @var TagRepository
     */
    protected $tagRepository;

    public function create(\Splio\WatchBundle\Command\LinkCreateCommand $command)
    {
        $link = new Link();
        $link->setCreatedAt(new \DateTime());
        $link->setUrl($command->url);
        $command->user->addLink($link); // one to many
        $link->setUser($command->user); // many to one, owner side

        $this->linkRepository->save($link);
        $command->setLink($link);

        return $link;
    }

    public function getTags(Link $link, $offset = 0, $limit = 10)
    {
        $tags = $this->tagRepository->getLinkTags($link, $offset, $limit);

        return $tags;
    }

    public function countTags(Link $link)
    {
        $count = $this->tagRepository->countLinkTags($link);

        return $count;
    }

    public function getLinks($offset = 0, $limit = 10)
    {
        $links = $this->linkRepository->get($offset, $limit);

        return $links;
    }

    public function get($id)
    {
        $link = $this->linkRepository->find($id);

        return $link;
    }

    public function count()
    {
        $count = $this->linkRepository->count();

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
}
