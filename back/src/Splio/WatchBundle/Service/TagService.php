<?php

namespace Splio\WatchBundle\Service;

use Doctrine\ORM\EntityManager;
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

    public function create($name)
    {
        $tag = new Tag();
        $tag->setCreatedAt(new \DateTime());
        $tag->setName($name);

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $tag;
    }

    public function getByName($name)
    {
        $tag = $this->tagRepository->getByName($name);

        return $tag;
    }

    public function getLinks(Tag $tag, $offset = 0, $limit = 10)
    {
        $links = $this->linkRepository->getTagLinks($tag, $offset, $limit);

        return $links;
    }

    public function countLinks(Tag $tag)
    {
        $count = $this->linkRepository->countTagLinks($tag);

        return $count;
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

    public function count()
    {
        $count = $this->tagRepository->count();

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

    public function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
    }
}
