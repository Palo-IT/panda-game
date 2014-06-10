<?php

namespace PandaGame\Bundle\ScoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PandaGame\Bundle\UserBundle\PandaGameUserBundle;

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
        $qb = $this->createQueryBuilder('Score');

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
