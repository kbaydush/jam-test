<?php

namespace InviteVendor\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use InviteVendor\UserBundle\Exception\InvalidInviteFilterValidation;
use InviteVendor\UserBundle\Exception\InvalidInviteValidation;
use InviteVendor\UserBundle\Exception\InviteNotFoundException;
use InviteVendor\UserBundle\Model\InviteFilter;
use InviteVendor\UserBundle\Service\Invite as InviteService;
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
 * @RouteResource("invites")
 */
class InviteController extends FOSRestController
{

    /**
     * @param Request $request
     * @return Response
     *
     * TODO: submit behavior functionality
     */
    public function listAction(Request $request)
    {
        $filter = InviteFilter::createFromRequest($request);

        $invites = $this->getInviteService()->getInvites($filter);
        $invitesCount = $this->getInviteService()->getInviteRecordAmount();

        return $this->render('UserBundle:Invited:list.html.twig', array( 'invites' => $invites, 'count' => $invitesCount
            // ...
        ));
    }

    /**
     * @param $param
     *
     * @return Response
     *
     * TODO: accept behavior functionality
     */
    public function acceptAction($param)
    {

        return $this->render('UserBundle:Invited:accept.html.twig', array(
            // ...
        ));
    }

    /**
     * @return Response
     *
     * TODO: behavior functionality
     */
    public function declineAction()
    {
        return $this->render('UserBundle:Invited:decline.html.twig', array(
            // ...
        ));
    }

    /**
     * @throws InvalidParameterException
     * @throws InvalidInviteFilterValidation
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function cgetAction(Request $request): View
    {
        $filter = InviteFilter::createFromRequest($request);

        $invites = $this->getInviteService()->getInvites($filter);
        $inviteCount = $this->getInviteService()->getInviteRecordAmount();

        $view = $this->view($invites);
        $view->setHeader('X-Total-Records', $inviteCount);

        return $view;
    }

    /**
     * @throws NonUniqueResultException
     * @throws InviteNotFoundException
     */
    public function getAction(string $inviteId): View
    {
        $invite = $this->getInviteService()->getInvite($inviteId);

        return $this->view($invite);
    }


    /**
     *
     * @throws LogicException
     * @throws InvalidInviteValidation
     * @throws InviteNotFoundException
     * @throws NonUniqueResultException
     */

    public function createAction(Request $request): View
    {
        $data = (string) $request->getContent();
        $newInvite = $this->getInviteService()->createInvite($data);

        return $this->view($newInvite);
    }

    /**
     * @throws LogicException
     * @throws InvalidInviteValidation
     * @throws InviteNotFoundException
     * @throws NonUniqueResultException
     */
    public function putAction(string $inviteId, Request $request): View
    {
        $invite = $this->getInviteService()->getInvite($inviteId);
        $data = (string) $request->getContent();
        $updatedInvite = $this->getInviteService()->updateInvite($invite, $data);

        return $this->view($updatedInvite);
    }

    /**
     * @throws LogicException
     * @throws InvalidTargetDocumentJsonException
     * @throws InvalidPatchDocumentJsonException
     * @throws InvalidOperationException
     * @throws FailedTestException
     * @throws InvalidInviteValidation
     * @throws InviteNotFoundException
     * @throws NonUniqueResultException
     */
    public function patchAction(string $inviteId, Request $request): View
    {
        $invite = $this->getInviteService()->getInvite($inviteId);
        $data = (string) $request->getContent();
        $updatedInvite = $this->getInviteService()->patchInvite($invite, $data);

        return $this->view($updatedInvite);
    }

    private function getInviteService(): InviteService
    {
        return $this->get('app.service.invite');
    }


}
