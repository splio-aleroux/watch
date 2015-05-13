<?php

namespace Splio\WatchBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function save(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getByEmail($email)
    {
        return $this->createQueryBuilder("u")
            ->where("u.email =:email")
            ->setParameter("email", $email)
            ->getQuery()->getResult()
            ;
    }

    public function getBySecretKey($secretKey)
    {
        return $this->createQueryBuilder("u")
            ->where("u.secretKey =:secretKey")
            ->setParameter("secretKey", $secretKey)
            ->getQuery()->getResult()
            ;
    }

    public function get($offset = 0, $limit = 10)
    {
        return $this->createQueryBuilder("u")
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()->getResult()
            ;
    }

    public function count()
    {
        return $this->createQueryBuilder("u")
            ->select('count(u.id)')
            ->getQuery()->getSingleScalarResult()
            ;
    }
}
