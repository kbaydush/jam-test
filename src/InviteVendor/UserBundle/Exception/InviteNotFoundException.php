<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InviteNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('Invite not found.');
    }
}
