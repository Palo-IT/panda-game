<?php

namespace PandaGame\Bundle\ScoreBundle\Controller;

use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use PandaGame\Bundle\CommonBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @RouteResource("Score")
 */
class ScoreController extends BaseController
{
    /**
     * @View
     *
     * @ApiDoc(resource=true, description="Get scores by username or for all")
     */
    public function cgetAction(Request $request)
    {
        $defaultOrder = array('creation' => 'DESC');
        $order = $this->formatOrderAsArray($request->get('order'), $defaultOrder);

        $scores = $this->getScoreRepository()->findBy(array(), $order);

        $view = $this->view($scores, $this->getResponseCodeForList($scores));

        return $this->handleView($view);
    }
}
