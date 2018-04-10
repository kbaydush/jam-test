<?php

namespace InviteVendor\UserBundle\Controller;

use InviteVendor\UserBundle\Exception\InvalidUserFilterValidation;
use InviteVendor\UserBundle\Exception\InvalidUserValidation;
use InviteVendor\UserBundle\Exception\UserNotFoundException;
use InviteVendor\UserBundle\Model\UserFilter;
use InviteVendor\UserBundle\Service\User as UserService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Exception\InvalidParameterException;
use FOS\RestBundle\View\View;
use LogicException;
use Rs\Json\Patch\FailedTestException;
use Rs\Json\Patch\InvalidOperationException;
use Rs\Json\Patch\InvalidPatchDocumentJsonException;
use Rs\Json\Patch\InvalidTargetDocumentJsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * @RouteResource("users")
 */
class UserController extends FOSRestController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $filter = UserFilter::createFromRequest($request);

        $players = $this->getUserService()->getUsers($filter);
        $playerCount = $this->getUserService()->getUserRecordAmount();

        return $this->render('UserBundle:Sender:list.html.twig', array( 'players' => $players, 'count' => $playerCount
            // ...
        ));
    }

    /**
     * @throws InvalidParameterException
     * @throws InvalidUserFilterValidation
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function cgetAction(Request $request): View
    {
        $filter = UserFilter::createFromRequest($request);

        $users = $this->getUserService()->getUsers($filter);
        $userCount = $this->getUserService()->getUserRecordAmount();

        $view = $this->view($users);
        $view->setHeader('X-Total-Records', $userCount);

        return $view;
    }

    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     */
    public function getAction(string $userId): View
    {
        $user = $this->getUserService()->getUser($userId);

        return $this->view($user);
    }


    /**
     *
     * @throws LogicException
     * @throws InvalidUserValidation
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */

    public function createAction(Request $request): View
    {
        $data = (string) $request->getContent();
        $newUser = $this->getUserService()->createUser($data);

        return $this->view($newUser);
    }

    /**
     * @throws LogicException
     * @throws InvalidUserValidation
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */
    public function putAction(string $userId, Request $request): View
    {
        $user = $this->getUserService()->getUser($userId);
        $data = (string) $request->getContent();
        $updatedUser = $this->getUserService()->updateUser($user, $data);

        return $this->view($updatedUser);
    }

    /**
     * @throws LogicException
     * @throws InvalidTargetDocumentJsonException
     * @throws InvalidPatchDocumentJsonException
     * @throws InvalidOperationException
     * @throws FailedTestException
     * @throws InvalidUserValidation
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */
    public function patchAction(string $userId, Request $request): View
    {
        $user = $this->getUserService()->getUser($userId);
        $data = (string) $request->getContent();
        $updatedUser = $this->getUserService()->patchUser($user, $data);

        return $this->view($updatedUser);
    }

    private function getUserService(): UserService
    {
        return $this->get('app.service.user');
    }

}
