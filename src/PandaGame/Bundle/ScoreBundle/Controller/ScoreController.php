<?php

namespace PandaGame\Bundle\ScoreBundle\Controller;

use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use PandaGame\Bundle\CommonBundle\Controller\BaseController;
use PandaGame\Bundle\ScoreBundle\Entity\Score;
use PandaGame\Bundle\ScoreBundle\Form\Type\ScoreType;

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
     * @QueryParam(
     *  name="limit",
     *  requirements="int",
     *  description="Maximum number of Scores returned."
     * )
     *
     * @ApiDoc(resource=true, description="Get scores by username or for all")
     */
    public function cgetAction(Request $request)
    {
        $defaultOrder = array('creation' => 'DESC');
        $order        = $this->formatOrderAsArray($request->get('order'), $defaultOrder);

        $scores = $this->getScoreRepository()->findBy(array(), $order, $request->get('limit'));

        $view = $this->view($scores, $this->getResponseCodeForList($scores));
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('list')));

        return $this->handleView($view);
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @View
     *
     * @ApiDoc(resource=true, description="Get a score by id")
     */
    public function getAction($id)
    {
        $score = $this->getScoreRepository()->find($id);

        if (!$score) {
            throw new NotFoundHttpException();
        }

        $view = $this->view($score, Response::HTTP_OK);

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

        return $this->processForm($request, $score);
    }

    /**
     * @param Request $request
     * @param Score   $score
     *
     * @return Response
     */
    private function processForm(Request $request, Score $score)
    {
        $statusCode = $score->isNew() ? Response::HTTP_CREATED : Response::HTTP_NO_CONTENT;

        $form = $this->createForm(new ScoreType(), $score, array('method' => 'POST'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($score);
            $this->getEntityManager()->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            if (Response::HTTP_CREATED === $statusCode) {
                $response->headers->set(
                    'Location',
                    $this->generateUrl(
                        'score_get_score',
                        array('id' => $score->getId()),
                        true
                    )
                );
            }

            return $response;
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);

        return $this->handleView($view);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($id)
    {
        $score = $this->getScoreRepository()->find($id);

        if (!$score) {
            throw new NotFoundHttpException();
        }

        $this->getEntityManager()->remove($score);
        $this->getEntityManager()->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
