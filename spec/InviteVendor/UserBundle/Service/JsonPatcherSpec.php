<?php

namespace spec\InviteVendor\UserBundle\Service;

use InviteVendor\UserBundle\Service\JsonPatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonPatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonPatcher::class);
    }
}
