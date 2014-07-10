<?php

namespace PandaGame\Bundle\SponsorBundle\Controller;

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
use PandaGame\Bundle\SponsorBundle\Entity\Sponsor;
use PandaGame\Bundle\ScoreBundle\Form\Type\ScoreType;

/**
 * @RouteResource("Sponsor")
 */
class SponsorController extends BaseController
{
    /**
     * @View
     * @QueryParam(
     *  name="order",
     *  requirements="(creation|creation-)",
     *  description="Order results by parameter. If the parameter is prefixed by '-' we go in decreasing order."
     * )
     *
     * @ApiDoc(resource=true, description="Get all scores")
     */
    public function cgetAction(Request $request)
    {
        $defaultOrder = array('type' => 'DESC', 'name' => 'ASC');
        $order        = $this->formatOrderAsArray($request->get('order'), $defaultOrder);

        $sponsors = $this->getSponsorRepository()->findBy(array(), $order);

        $view = $this->view($sponsors, $this->getResponseCodeForList($sponsors));
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('list')));

        return $this->handleView($view);
    }

    /**
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @View
     *
     * @ApiDoc(resource=true, description="Get a sponsor by slug")
     */
    public function getAction($slug)
    {
        $sponsor = $this->getSponsorRepository()->findOneBy(array('slug' => $slug));

        if (!$sponsor) {
            throw new NotFoundHttpException();
        }

        $view = $this->view($sponsor, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        $sponsor = new Sponsor();

        return $this->processForm($request, $sponsor);
    }

    /**
     * @param Request $request
     * @param Sponsor $sponsor
     *
     * @return Response
     */
    private function processForm(Request $request, Sponsor $sponsor)
    {
        $statusCode = $sponsor->isNew() ? Response::HTTP_CREATED : Response::HTTP_NO_CONTENT;

        $form = $this->createForm(new ScoreType(), $sponsor, array('method' => 'POST'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($sponsor);
            $this->getEntityManager()->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            if (Response::HTTP_CREATED === $statusCode) {
                $response->headers->set(
                    'Location',
                    $this->generateUrl(
                        'sponsor_get_sponsor',
                        array('id' => $sponsor->getSlug()),
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
     * @param $slug
     *
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($slug)
    {
        $sponsor = $this->getSponsorRepository()->findBy(array('slug' => $slug));

        if (!$sponsor) {
            throw new NotFoundHttpException();
        }

        $this->getEntityManager()->remove($sponsor);
        $this->getEntityManager()->flush();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
