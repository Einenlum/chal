<?php

namespace spec\App\Domain\Model\Geolocation;

use App\Domain\Model\Geolocation\Distance;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistanceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Distance::class);
    }

    function it_is_constructed_as_a_meter_distance()
    {
        $this->beConstructedThrough('meters', [23.97]);
        $this->getType()->shouldReturn(Distance::UNIT_METERS);
        $this->getValue()->shouldReturn(23.97);
    }
}
