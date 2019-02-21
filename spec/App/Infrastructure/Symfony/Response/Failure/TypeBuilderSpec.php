<?php

namespace spec\App\Infrastructure\Symfony\Response\Failure;

use App\Infrastructure\Symfony\Response\Failure\TypeBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TypeBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TypeBuilder::class);
    }

    function it_returns_a_default_value_if_not_http_exception()
    {
        $exception = new \RuntimeException();
        $this->createType($exception)->shouldReturn('Internal Server Error');
    }

    function it_returns_a_readable_type_for_http_exceptions()
    {
        $exception = new BadRequestHttpException();
        $this->createType($exception)->shouldReturn('Bad Request');
    }
}
