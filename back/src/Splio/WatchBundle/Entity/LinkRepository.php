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
        return $this->createQueryBuilder("l")
            ->innerJoin("l.tags", "t", "WITH", "t=:tag")
            ->setParameter("tag", $tag)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult()
        ;
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
            ->getQuery()->getResult()
        ;
    }
}
