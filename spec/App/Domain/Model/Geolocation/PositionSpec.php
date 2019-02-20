<?php

namespace spec\App\Domain\Model\Geolocation;

use App\Domain\Model\Geolocation\Position;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Domain\Exception\Geolocation\Position\InvalidLatitudeException;
use App\Domain\Exception\Geolocation\Position\InvalidLongitudeException;

class PositionSpec extends ObjectBehavior
{
    function it_is_initializable_with_valid_values()
    {
        $this->beConstructedWith(-43.03098, 143.235);
        $this->shouldHaveType(Position::class);
    }

    function it_throws_an_exception_if_latitude_is_invalid()
    {
        $this
            ->shouldThrow(InvalidLatitudeException::class)
            ->during('__construct', [-123., 60.])
        ;
        $this
            ->shouldThrow(InvalidLatitudeException::class)
            ->during('__construct', [123., 60.])
        ;
    }

    function it_throws_an_exception_if_longitude_is_invalid()
    {
        $this
            ->shouldThrow(InvalidLongitudeException::class)
            ->during('__construct', [23., -81260.])
        ;
        $this
            ->shouldThrow(InvalidLongitudeException::class)
            ->during('__construct', [23., 602323.])
        ;
    }
}
