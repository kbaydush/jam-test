<?php

namespace spec\InviteVendor\UserBundle\Exception;

use InviteVendor\UserBundle\Exception\UserNotFoundException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserNotFoundException::class);
    }
}
