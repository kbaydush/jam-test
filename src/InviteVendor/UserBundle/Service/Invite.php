<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Service;

use InviteVendor\UserBundle\Entity\Invite as InviteEntity;
use InviteVendor\UserBundle\Exception\InvalidInviteFilterValidation;
use InviteVendor\UserBundle\Exception\InvalidInviteValidation;
use InviteVendor\UserBundle\Manager\InviteManager;
use InviteVendor\UserBundle\Model\InviteFilter;
use JMS\Serializer\Serializer;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class Invite
{
    private $inviteManager;
    private $jsonPatcher;
    private $recursiveValidator;
    private $serializer;

    /**
     * @param InviteManager        $inviteManager
     * @param JsonPatcher        $jsonPatcher
     * @param RecursiveValidator $recursiveValidator
     * @param Serializer         $serializer
     */
    public function __construct(InviteManager $inviteManager, JsonPatcher $jsonPatcher, RecursiveValidator $recursiveValidator, Serializer $serializer)
    {
        $this->inviteManager      = $inviteManager;
        $this->recursiveValidator = $recursiveValidator;
        $this->serializer         = $serializer;
        $this->jsonPatcher        = $jsonPatcher;
    }

    public function getInvites(InviteFilter $filter): array
    {
        $validator = $this->recursiveValidator->validate($filter);

        if (0 !== $validator->count()) {
            // throw exception
            throw new InvalidInviteFilterValidation($validator);
        }

        // return the return value
        $return = $this->inviteManager->getInvites($filter);

        return $return;
    }

    public function updateInvite($originalInvite, $data)
    {
        $newInvite = $this->serializer->deserialize($data, InviteEntity::class, 'json');

        $validator = $this->recursiveValidator->validate($newInvite);
        if (0 !== $validator->count()) {
            throw new InvalidInviteValidation($validator);
        }

        return $this->inviteManager->updateInvite($originalInvite, $newInvite);
    }

    public function patchInvite(InviteEntity $originalInvite, string $patchDocument): InviteEntity
    {
        $targetDocument  = $this->serializer->serialize($originalInvite, 'json');
        $patchedDocument = $this->jsonPatcher->patch($targetDocument, $patchDocument);
        $newInvite       = $this->serializer->deserialize($patchedDocument, InviteEntity::class, 'json');

        $validator = $this->recursiveValidator->validate($newInvite);

        if (0 !== $validator->count()) {
            throw new InvalidInviteValidation($validator);
        }

        return $this->inviteManager->updateInvite($originalInvite, $newInvite);
    }

    public function getInvite(string $inviteId): InviteEntity
    {
        return $this->inviteManager->getInvite($inviteId);
    }

    public function getInviteRecordAmount(): int
    {
        return $this->inviteManager->getInviteRecordAmount();
    }

    public function createInvite($data)
    {
        $newInvite = $this->serializer->deserialize($data, InviteEntity::class, 'json');

        $validator = $this->recursiveValidator->validate($newInvite);
        if (0 !== $validator->count()) {
            throw new InvalidInviteValidation($validator);
        }

        return $this->inviteManager->createInvite($newInvite);
    }
}
