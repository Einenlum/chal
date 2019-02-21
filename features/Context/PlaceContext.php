<?php

declare(strict_types=1);

namespace Context;

use Behat\Behat\Context\Context;
use Test\Client;

final class PlaceContext implements Context
{
    use HasClient;

    const PLACE_CREATION_ROUTE = '/places';

    private $createdPlaceId;

    /**
     * @When I create a place with valid information
     */
    public function createAValidPlace()
    {
        $response = $this->client->post(
            self::PLACE_CREATION_ROUTE,
            [
                'name' => 'Berghain',
                'type' => 'concert hall',
                'latitude' => 52.51138,
                'longitude' => 13.44334,
            ]
        );
        $this->createdPlaceId = $this->client->decodeLastResponse();
    }

    /**
     * @When I try to create a place with an invalid payload
     */
    public function tryToCreateAPlaceWithInvalidPayload()
    {
        $this->client->post(
            self::PLACE_CREATION_ROUTE,
            [
                'name' => 'Berghain',
                'type' => 'concert hall',
                'latitude' => 2307.98, // Invalid latitude
                'longitude' => 13.44334,
            ],
            Client::DONT_THROW_IF_ERRORS
        );
    }

    /**
     * @Then I should get the confirmation that a place was created
     */
    public function aPlaceWasCreated()
    {
        if ($this->client->lastResponseHasErrors()) {
            throw new \Exception();
        }
    }

    public function getIdOfLastPlaceCreated()
    {
        return $this->createdPlaceId;
    }
}
