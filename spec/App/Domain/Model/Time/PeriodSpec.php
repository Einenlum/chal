<?php

namespace spec\App\Domain\Model\Time;

use App\Domain\Model\Time\Period;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Domain\Exception\Time\InvalidPeriodException;

class PeriodSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
        $this->shouldHaveType(Period::class);
    }

    function it_is_constructed_with_valid_dates()
    {
        $start = new \DateTimeImmutable();
        $end = new \DateTimeImmutable('+1 day');

        $this->beConstructedWith($start, $end);
        $this->getStart()->shouldReturn($start);
        $this->getEnd()->shouldReturn($end);
    }

    function it_throws_exception_if_constructed_with_invalid_dates()
    {
        $start = new \DateTimeImmutable('+1 day');
        $end = new \DateTimeImmutable('-1 day');

        $this
            ->shouldThrow(InvalidPeriodException::class)
            ->during('__construct', [$start, $end])
        ;
    }
}
