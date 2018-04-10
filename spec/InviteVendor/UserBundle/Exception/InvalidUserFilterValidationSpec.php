<?php

namespace spec\AppBundle\Exception;

use AppBundle\Exception\InvalidPlayerFilterValidation;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidUserFilterValidationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidUserFilterValidation::class);
    }

    function it_is_an_http_exception_extension()
    {
        $this->shouldHaveType(HttpException::class);
    }

    function let(ConstraintViolationListInterface $validator)
    {
        $this->beConstructedWith($validator);
    }

    function it_should_convert_a_list_of_validation_errors_to_a_message()
    {
        $violation = new ConstraintViolation(
            'the property length is too long.',
            '',
            [],
            '',
            'a property',
            'wrong'
        );
        $validator = new ConstraintViolationList([$violation]);

        $this->beConstructedWith($validator);
        $message = 'UserFilter validation failed. a property: the property length is too long.';

        $this->getMessage()->shouldBe($message);
    }
}
