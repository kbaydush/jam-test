<?php

namespace spec\InviteVendor\UserBundle\Model;

use InviteVendor\UserBundle\Model\UserFilter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserFilter::class);
    }
}
