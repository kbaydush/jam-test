<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Service;

use InviteVendor\UserBundle\Entity\User as UserEntity;
use InviteVendor\UserBundle\Exception\InvalidUserFilterValidation;
use InviteVendor\UserBundle\Exception\InvalidUserValidation;
use InviteVendor\UserBundle\Manager\UserManager;
use InviteVendor\UserBundle\Model\UserFilter;
use JMS\Serializer\Serializer;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class User
{
    private $userManager;
    private $jsonPatcher;
    private $recursiveValidator;
    private $serializer;

    /**
     * @param UserManager        $userManager
     * @param JsonPatcher        $jsonPatcher
     * @param RecursiveValidator $recursiveValidator
     * @param Serializer         $serializer
     */
    public function __construct(UserManager $userManager, JsonPatcher $jsonPatcher, RecursiveValidator $recursiveValidator, Serializer $serializer)
    {
        $this->userManager      = $userManager;
        $this->recursiveValidator = $recursiveValidator;
        $this->serializer         = $serializer;
        $this->jsonPatcher        = $jsonPatcher;
    }

    public function getUsers(UserFilter $filter): array
    {
        $validator = $this->recursiveValidator->validate($filter);

        if (0 !== $validator->count()) {
            // throw exception
            throw new InvalidUserFilterValidation($validator);
        }

        // return the return value
        $return = $this->userManager->getUsers($filter);

        return $return;
    }

    public function updateUser($originalUser, $data)
    {
        $newUser = $this->serializer->deserialize($data, UserEntity::class, 'json');

        $validator = $this->recursiveValidator->validate($newUser);
        if (0 !== $validator->count()) {
            throw new InvalidUserValidation($validator);
        }

        return $this->userManager->updateUser($originalUser, $newUser);
    }

    public function patchUser(UserEntity $originalUser, string $patchDocument): UserEntity
    {
        $targetDocument  = $this->serializer->serialize($originalUser, 'json');
        $patchedDocument = $this->jsonPatcher->patch($targetDocument, $patchDocument);
        $newUser       = $this->serializer->deserialize($patchedDocument, UserEntity::class, 'json');

        $validator = $this->recursiveValidator->validate($newUser);

        if (0 !== $validator->count()) {
            throw new InvalidUserValidation($validator);
        }

        return $this->userManager->updateUser($originalUser, $newUser);
    }

    public function getUser(string $userId): UserEntity
    {
        return $this->userManager->getUser($userId);
    }

    public function getUserRecordAmount(): int
    {
        return $this->userManager->getUserRecordAmount();
    }

    public function createUser($data)
    {
        $newUser = $this->serializer->deserialize($data, UserEntity::class, 'json');

        $validator = $this->recursiveValidator->validate($newUser);
        if (0 !== $validator->count()) {
            throw new InvalidUserValidation($validator);
        }

        return $this->userManager->createUser($newUser);
    }
}
