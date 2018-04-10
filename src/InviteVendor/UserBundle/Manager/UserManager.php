<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Manager;

use InviteVendor\UserBundle\Entity\User;
use InviteVendor\UserBundle\Exception\UserNotFoundException;
use InviteVendor\UserBundle\Model\UserFilter;
use InviteVendor\UserBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use JMS\Serializer\Serializer;

class UserManager
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

    public function getUsers(UserFilter $filter): array
    {
        return $this->getRepository()->findAllByUsersFilter($filter);
    }

    public function updateUser(User $originalUser, User $newUser): User
    {
        $originalUser->setExternalId($newUser->getExternalId());
        $originalUser->setCountry($newUser->getCountry());
        $originalUser->setMusicInstrument($newUser->getMusicInstrument());
        $originalUser->setDateOfBirth($newUser->getDateOfBirth());
        $originalUser->setCountry($newUser->getCountry());
        $originalUser->setNotes($newUser->getNotes());
        $originalUser->setUsername($newUser->getUsername());

        if (null !== $newUser->getSex()) {
            $originalUser->setSex($newUser->getSex());
        }

        $this->entityManager->flush();

        return $originalUser;
    }


    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     */
    public function getUser(string $UserId): User
    {
        return $this->getRepository()->findUser($UserId);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getUserRecordAmount(): int
    {
        return $this->getRepository()->getUserRecordAmount();
    }

    private function getRepository(): UserRepository
    {
        return $this->entityManager->getRepository(User::class);
    }

    public function createUser($newUser): User
    {
        $originalUser = new User();
        $originalUser->setExternalId($newUser->getExternalId());
        $originalUser->setCountry($newUser->getCountry());
        $originalUser->setMusicInstrument($newUser->getMusicInstrument());
        $originalUser->setDateOfBirth($newUser->getDateOfBirth());
        $originalUser->setCountry($newUser->getCountry());
        $originalUser->setNotes($newUser->getNotes());
        $originalUser->setUsername($newUser->getUsername());

        if (null !== $newUser->getSex()) {
            $originalUser->setSex($newUser->getSex());
        }

        $this->entityManager->flush();

        return $newUser;
    }
}
