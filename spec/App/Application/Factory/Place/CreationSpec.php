<?php

namespace spec\App\Application\Factory\Place;

use App\Application\Factory\Place\Creation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Application\DTO\Place\Create;
use App\Domain\Model\Place;

class CreationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Creation::class);
    }

    function it_creates_a_place_from_a_create_dto()
    {
        $dto = Create::fromArray([
            'name' => 'lorem',
            'type' => Place::TYPE_GALLERY,
            'latitude' => 23.23,
            'longitude' => -42.2132,
        ]);

        $place = $this->createPlace($dto);
        $place->shouldBeAnInstanceOf(Place::class);
    }
}
