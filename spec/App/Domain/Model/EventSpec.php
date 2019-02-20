<?php

namespace spec\App\Domain\Model;

use App\Domain\Model\Event;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Domain\Model\Time\Period;
use App\Domain\Model\Place;
use App\Domain\Model\Geolocation\Position;

class EventSpec extends ObjectBehavior
{
    function it_returns_a_valid_period()
    {
        $place = new Place('Olympia', new Position(-1., 2.), Place::TYPE_CONCERT_HALL);
        $period = new Period(
            new \DateTimeImmutable(),
            new \DateTimeImmutable('+1 day')
        );

        $this->beConstructedWith(
            $place,
            $period,
            'Lady Gaga',
            Event::TYPE_CONCERT
        );
        $this->shouldHaveType(Event::class);

        // The period is a new object created on the fly while asked
        $this->getPeriod()->shouldNotBe($period);
        $this->getPeriod()->shouldBeAnInstanceOf(Period::class);
    }
}
