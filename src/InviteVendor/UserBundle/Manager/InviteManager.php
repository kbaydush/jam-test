<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Manager;

use InviteVendor\UserBundle\Entity\Invite;
use InviteVendor\UserBundle\Exception\InviteNotFoundException;
use InviteVendor\UserBundle\Model\InviteFilter;
use InviteVendor\UserBundle\Repository\InviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use JMS\Serializer\Serializer;

class InviteManager
{
    private $entityManager;
    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        Serializer $serializer
    ) {
        $this->entityManager = $entityManager;
        $this->serializer    = $serializer;
    }

    public function getInvites(InviteFilter $filter): array
    {
        return $this->getRepository()->findAllByInviteFilter($filter);
    }

    public function updateInvite(Invite $originalInvite, Invite $newInvite): Invite
    {
        $originalInvite->setSenderId($newInvite->getSenderId());
        $originalInvite->setInvitedId($newInvite->getInvitedId());
        $originalInvite->setStatus($newInvite->getStatus());
        $originalInvite->setTime($newInvite->getTime());

        if (null !== $newInvite->getMessage()) {
            $originalInvite->setMessage($newInvite->getMessage());
        }

        $this->entityManager->flush();

        return $originalInvite;
    }


    /**
     * @throws NonUniqueResultException
     * @throws InviteNotFoundException
     */
    public function getInvite(string $InviteId): Invite
    {
        return $this->getRepository()->findInvite($InviteId);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getInviteRecordAmount(): int
    {
        return $this->getRepository()->getInviteRecordAmount();
    }

    private function getRepository(): InviteRepository
    {
        return $this->entityManager->getRepository(Invite::class);
    }

    public function createInvite($newInvite): Invite
    {
        $originalInvite = new Invite();
        $originalInvite->setSenderId($newInvite->getSenderId());
        $originalInvite->setInvitedId($newInvite->getInvitedId());
        $originalInvite->setStatus($newInvite->getStatus());
        $originalInvite->setTime($newInvite->getTime());

        if (null !== $newInvite->getMessage()) {
            $originalInvite->setMessage($newInvite->getMessage());
        }

        $this->entityManager->flush();

        return $newInvite;
    }
}
