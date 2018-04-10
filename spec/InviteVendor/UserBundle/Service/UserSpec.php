<?php

namespace spec\InviteVendor\UserBundle\Service;

use InviteVendor\UserBundle\Service\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }
}
