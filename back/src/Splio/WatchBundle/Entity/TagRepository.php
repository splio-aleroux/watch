<?php

namespace Splio\WatchBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TagRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagRepository extends EntityRepository
{
    /**
     * [findTagsOfLink description]
     * @param  Link    $link   [description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]  [description]
     */
    public function getLinkTags(Link $link, $offset = 0, $limit = 10)
    {
        return $this->createQueryBuilder("t")
            ->innerJoin("t.links", "l", "WITH", "l=:link")
            ->setParameter("link", $link)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    /**
     * [findTagsOfUser description]
     * @param  User    $user   [description]
     * @param  integer $offset [description]
     * @param  integer $limit  [description]
     * @return [type]  [description]
     */
    public function getUserTags(User $user, $offset = 0, $limit = 10)
    {
        return $this->createQueryBuilder("t")
            ->innerJoin("t.links", 'l')
            ->innerJoin("l.user", "u", "WITH", "u=:user")
            ->setParameter("user", $user)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function get($offset = 0, $limit = 10)
    {
        return $this->createQueryBuilder("t")
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function count()
    {
        return $this->createQueryBuilder("t")
            ->select('count(t.id)')
            ->getQuery()->getSingleScalarResult();
    }
}
