<?php

namespace PandaGame\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use PandaGame\Bundle\CommonBundle\Controller\BaseController;

/**
 * @RouteResource("User")
 */
class UserController extends BaseController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @View
     * @QueryParam(
     *  name="order",
     *  requirements="(username|username-)",
     *  description="Order results by parameter. If the parameter is prefixed by '-' we go in decreasing order."
     * )
     *
     * @ApiDoc(resource=true, description="Get all the users")
     */
    public function cgetAction(Request $request)
    {
        $defaultOrder = array('username' => 'ASC');
        $order = $this->formatOrderAsArray($request->get('order'), $defaultOrder);

        $users = $this->getUserRepository()->findBy(array(), $order);

        $view = $this->view($users, $this->getResponseCodeForList($users));
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('list')));

        return $this->handleView($view);
    }

    /**
     * @param $usernameCanonical
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @View
     *
     * @ApiDoc(resource=true, description="Get all the scores by usernameCanonical")
     */
    public function getScoresAction(Request $request, $usernameCanonical)
    {
        $user = $this->getUserRepository()->findOneByUsernameCanonical($usernameCanonical);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $defaultOrder = array('creation' => 'ASC');
        $order = $this->formatOrderAsArray($request->get('order'), $defaultOrder);

        $criteria = array('user' => $user);
        $scores = $this->getScoreRepository()->findBy($criteria, $order);

        $view = $this->view($scores, $this->getResponseCodeForList($scores));
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('list')));

        return $this->handleView($view);
    }

    /**
     * @param $usernameCanonical
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     *
     * @View
     *
     * @ApiDoc(resource=true, description="Get a user by usernameCanonical")
     */
    public function getAction($usernameCanonical)
    {
        $user = $this->getUserRepository()->findOneByUsernameCanonical($usernameCanonical);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $view = $this->view($user, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        return new JsonResponse(
            null,
            Response::HTTP_CREATED
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $usernameCanonical
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return JsonResponse
     */
    public function putAction(Request $request, $usernameCanonical)
    {
        $user = $this->getUserRepository()->findOneByUsernameCanonical($usernameCanonical);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }

    /**
     * @param $usernameCanonical
     *
     * @return JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function banAction($usernameCanonical)
    {
        $user = $this->getUserRepository()->findOneByUsernameCanonical($usernameCanonical);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }

    /**
     * @param $usernameCanonical
     *
     * @return JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($usernameCanonical)
    {
        $user = $this->getUserRepository()->findOneByUsernameCanonical($usernameCanonical);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(
            null,
            Response::HTTP_OK
        );
    }
}
