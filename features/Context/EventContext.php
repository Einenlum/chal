<?php

declare(strict_types=1);

namespace Context;

use Behat\Behat\Context\Context;
use Context\HasPlaceContext;
use Context\HasClient;
use Ramsey\Uuid\Uuid;
use Test\Client;

final class EventContext implements Context
{
    use HasClient;
    use HasPlaceContext;

    const ROUTE_EVENT_CREATE = '/places/{placeId}/events';
    const ROUTE_EVENT_GET = '/events/{eventId}';

    private $createdEvent;

    /**
     * @When I create an event for an existing place
     */
    public function createEventForExistingPlace()
    {
        $this->placeContext->createAValidPlace();
        $placeId = $this->placeContext->getIdOfLastPlaceCreated();

        $path = str_replace('{placeId}', $placeId, self::ROUTE_EVENT_CREATE);

        $periodStart = (new \DateTimeImmutable())->format(\DateTime::ATOM);
        $periodEnd = (new \DateTimeImmutable('+1 day'))->format(\DateTime::ATOM);
        $this
            ->client
            ->post($path, $this->templateForBaseEvent())
        ;
        $this->createdEvent = $this->client->decodeLastResponse();
    }

    /**
     * @When I try to create an event with a non existing place
     */
    public function tryToCreateEventWithNonExistingPlace()
    {
        $this->placeContext->createAValidPlace();
        $placeId = $this->placeContext->getIdOfLastPlaceCreated();

        $nonExistingId = Uuid::uuid4();
        $path = str_replace('{placeId}', $nonExistingId, self::ROUTE_EVENT_CREATE);

        $this
            ->client
            ->post($path, $this->templateForBaseEvent(), Client::DONT_THROW_IF_ERRORS)
        ;
    }

    /**
     * @When I ask for the details of an existing event
     */
    public function askForExistingEvent()
    {
        $this->createEventForExistingPlace();
        $id = $this->createdEvent['id'];

        $path = str_replace('{eventId}', $id, self::ROUTE_EVENT_GET);
        $this
            ->client
            ->get($path)
        ;
    }

    /**
     * @Then I should get the confirmation that an event was created
     */
    public function anEventShouldHaveBeenCreated()
    {
        $lastResponse = $this->client->decodeLastResponse();

        if ($lastResponse['name'] !== 'Nice DJ event'
            || $lastResponse['type'] !== 'concert'
        ) {
            throw new \Exception('The event was not created');
        }
    }

    /**
     * @Then I should get the details of this event, including its posts
     */
    public function shouldHaveTheDetailsOfTheEvent()
    {
        $lastResponse = $this->client->decodeLastResponse();

        $expected = ['name', 'type', 'posts'];
        foreach ($expected as $item) {
            if (!isset($lastResponse[$item])) {
                throw new \Exception(sprintf(
                    'No item %s found in the last response',
                    $item
                ));
            }
        }
    }

    private function templateForBaseEvent(): array
    {
        $periodStart = (new \DateTimeImmutable())->format(\DateTime::ATOM);
        $periodEnd = (new \DateTimeImmutable('+1 day'))->format(\DateTime::ATOM);

        return [
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
            'name' => 'Nice DJ event',
            'type' => 'concert'
        ];
    }
}
