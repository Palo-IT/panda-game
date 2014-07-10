<?php

namespace PandaGame\Bundle\ScoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ScorerRepository
 */
class ScoreRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        $qb = $this->createQueryBuilder('score');
        $qb->select('DISTINCT score');

        return $qb;
    }

    /**
     * @param \PandaGame\Bundle\UserBundle\Entity\User $user
     *
     * @return array
     */
    public function findForPublicList($user = null)
    {
        $criteria = array();
        if (!empty($usernameCanonical)) {
            $criteria['user'] = $user;
        }

        return $this->findBy(
            $criteria,
            array(
                'result'   => 'desc',
                'creation' => 'desc'
            )
        );
    }
}
