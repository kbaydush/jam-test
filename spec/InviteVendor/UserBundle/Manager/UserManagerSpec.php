<?php

namespace spec\InviteVendor\UserBundle\Manager;

use InviteVendor\UserBundle\Manager\UserManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserManager::class);
    }
}
