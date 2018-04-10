<?php

namespace spec\InviteVendor\UserBundle\EventListener;

use InviteVendor\UserBundle\EventListener\ExceptionListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExceptionListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExceptionListener::class);
    }
}
