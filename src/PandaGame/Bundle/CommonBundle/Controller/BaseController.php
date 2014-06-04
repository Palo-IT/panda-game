<?php

namespace PandaGame\Bundle\CommonBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends FOSRestController
{
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->get('doctrine')->getManager();
    }

    /**
     * @return \PandaGame\Bundle\UserBundle\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->getEntityManager()->getRepository('PandaGameUserBundle:User');
    }

    /**
     * @return \PandaGame\Bundle\UserBundle\Entity\User
     */
    public function getCurrentUser()
    {
        return $this->getUserRepository()->findOneBy(array('username' => 'Flynn'));
    }
}
