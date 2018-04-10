<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidUserFilterValidation extends HttpException
{
    public function __construct(ConstraintViolationListInterface $validator)
    {
        $message = 'UserFilter validation failed.';

        /** @var ConstraintViolationInterface $item */
        foreach ($validator as $item) {
            $message .= sprintf(' %s: %s', $item->getPropertyPath(), $item->getMessage());
        }

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }
}
