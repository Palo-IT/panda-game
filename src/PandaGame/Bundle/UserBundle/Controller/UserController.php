<?php

namespace PandaGame\Bundle\UserBundle\Controller;

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
     * @View
     * @QueryParam(
     *  name="sort",
     *  requirements="(username|-username)",
     *  description="Order results by parameter. If the parameter is prefixed by '-' we go in decreasing order."
     * )
     *
     * @ApiDoc(resource=true, description="Get all the users")
     */
    public function cgetAction()
    {
        $users = $this->getUserRepository()->findBy(array(), array('username' => 'ASC'));

        $view = $this->view($users , 200);
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('list')));

        return $this->handleView($view);
    }

    /**
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

        $view = $this->view($user, 200);

        return $this->handleView($view);
    }
}
