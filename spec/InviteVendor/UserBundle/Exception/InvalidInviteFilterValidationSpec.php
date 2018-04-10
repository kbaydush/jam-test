<?php

namespace spec\InviteVendor\UserBundle\Exception;

use InviteVendor\UserBundle\Exception\InvalidInviteFilterValidation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidInviteFilterValidationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidInviteFilterValidation::class);
    }
}
