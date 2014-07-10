<?php

namespace PandaGame\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('DISTINCT user');

        return $qb;
    }
}
