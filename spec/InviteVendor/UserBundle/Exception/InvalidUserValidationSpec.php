<?php

namespace spec\InviteVendor\UserBundle\Exception;

use InviteVendor\UserBundle\Exception\InvalidUserValidation;
use PhpSpec\ObjectBehavior;

class InvalidUserValidationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidUserValidation::class);
    }
}
