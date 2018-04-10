<?php

namespace spec\InviteVendor\UserBundle\Exception;

use InviteVendor\UserBundle\Exception\InviteNotFoundException;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InviteNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InviteNotFoundException::class);
    }

    function it_is_an_http_exception_extension()
    {
        $this->shouldHaveType(HttpException::class);
    }

    function it_should_have_a_message()
    {
        $this->beConstructedWith();
        $this->getMessage()->shouldBe('Invite not found.');
    }
}
