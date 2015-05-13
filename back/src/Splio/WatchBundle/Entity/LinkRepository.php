<?php

namespace Splio\WatchBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LinkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LinkRepository extends EntityRepository
{
    /**
     * [findLinksOfTag description]
     * @param  Tag     $tag    [description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]  [description]
     */
    public function getTagLinks(Tag $tag, $offset = 0, $limit = 10)
    {
        return $this->getQueryTagLinks($tag)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function countTagLinks(Tag $tag)
    {
        return $this->getQueryTagLinks($tag)
            ->select('count(l.id)')
            ->getQuery()->getSingleScalarResult();
    }

    public function getUserLinks(User $user, $offset = 0, $limit = 10)
    {
        return $this->getQueryUserLinks($user)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function countUserLinks(User $user)
    {
        return $this->getQueryUserLinks($user)
            ->select('count(l.id)')
            ->getQuery()->getSingleScalarResult();
    }

    private function getQueryTagLinks(Tag $tag)
    {
        return $this->createQueryBuilder("l")
            ->innerJoin("l.tags", "t", "WITH", "t=:tag")
            ->setParameter("tag", $tag);
    }

    private function getQueryUserLinks(User $user)
    {
        return $this->createQueryBuilder("l")
            ->where("l.user = :user")
            ->setParameter("user", $user);
    }

    /**
     * [findAllLinks description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]  [description]
     */
    public function get($offset = 0, $limit = 10)
    {
        return $this->createQueryBuilder("l")
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function count()
    {
        return $this->createQueryBuilder("l")
            ->select('count(l.id)')
            ->getQuery()->getSingleScalarResult();
    }
}
