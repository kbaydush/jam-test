<?php

namespace spec\InviteVendor\UserBundle\Exception;

use InviteVendor\UserBundle\Exception\InvalidInviteValidation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidInviteValidationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidInviteValidation::class);
    }
}
