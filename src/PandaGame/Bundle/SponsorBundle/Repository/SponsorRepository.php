<?php

namespace PandaGame\Bundle\SponsorBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SponsorRepository
 */
class SponsorRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        $qb = $this->createQueryBuilder('sponsor');
        $qb->select('DISTINCT sponsor');

        return $qb;
    }
}