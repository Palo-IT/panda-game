<?php

namespace PandaGame\Bundle\ScoreBundle\Controller;

use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use PandaGame\Bundle\CommonBundle\Controller\BaseController;
use PandaGame\Bundle\ScoreBundle\Entity\Score;
use PandaGame\Bundle\ScoreBundle\Form\Type\ScoreType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @RouteResource("Score")
 */
class ScoreController extends BaseController
{
    /**
     * @View
     * @QueryParam(
     *  name="order",
     *  requirements="(creation|creation-)",
     *  description="Order results by parameter. If the parameter is prefixed by '-' we go in decreasing order."
     * )
     *
     * @ApiDoc(resource=true, description="Get scores by username or for all")
     */
    public function cgetAction(Request $request)
    {
        $defaultOrder = array('creation' => 'DESC');
        $order = $this->formatOrderAsArray($request->get('order'), $defaultOrder);

        $scores = $this->getScoreRepository()->findBy(array(), $order);

        $view = $this->view($scores, $this->getResponseCodeForList($scores));
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('list')));

        return $this->handleView($view);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        $score = new Score();
        $score->setUser($this->getCurrentUser());

        $form = $this->createForm(new ScoreType(), $score);

        $form->handleRequest($request);

        return new JsonResponse(
            null,
            Response::HTTP_CREATED
        );
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($id)
    {
        $score = $this->getScoreRepository()->find($id);

        if (!$score) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }
}
