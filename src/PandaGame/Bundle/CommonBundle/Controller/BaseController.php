<?php

namespace PandaGame\Bundle\CommonBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

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
     * @return \PandaGame\Bundle\UserBundle\Entity\User
     */
    public function getCurrentUser()
    {
        return $this->getUserRepository()->findOneBy(array('username' => 'Flynn'));
    }

    /**
     * @return \PandaGame\Bundle\UserBundle\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->getEntityManager()->getRepository('PandaGameUserBundle:User');
    }

    /**
     * @return \PandaGame\Bundle\ScoreBundle\Repository\ScoreRepository
     */
    public function getScoreRepository()
    {
        return $this->getEntityManager()->getRepository('PandaGameScoreBundle:Score');
    }

    /**
     * @param $array
     *
     * @return int
     */
    public function getResponseCodeForList($array)
    {
        if (empty($array)) {
            return Response::HTTP_NO_CONTENT;
        }

        return Response::HTTP_OK;
    }

    /**
     * @param       $orderAsString
     * @param array $defaultOrder
     *
     * @return array
     */
    public function formatOrderAsArray($orderAsString, array $defaultOrder)
    {
        $formattedOrders = array();
        if (!empty($orderAsString)) {
            $ordersAsArray = explode(',', $orderAsString);

            foreach ($ordersAsArray as $order) {
                $orderOrientation = substr($order, -1);
                if ($orderOrientation == '-') {
                    $orderParam = substr($order, 0, -1);
                    $orderOrientation = 'DESC';
                } else {
                    $orderParam = $order;
                    $orderOrientation = 'ASC';
                }

                $formattedOrders[$orderParam] = $orderOrientation;
            }
        }

        if (empty($orderAsString) OR empty($formattedOrders)) {
            $formattedOrders = $defaultOrder;
        }

        return $formattedOrders;
    }

}
