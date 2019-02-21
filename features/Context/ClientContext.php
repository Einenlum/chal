<?php

declare(strict_types=1);

namespace Context;

use Test\Client;
use Symfony\Component\HttpFoundation\Request;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Call\BeforeScenario;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Test\Exception\ValidResponseException;

class ClientContext implements Context
{
    private $client;

    public function __construct(string $baseUrl) 
    {
        $this->client = Client::buildWithUrl($baseUrl);
    }

    /**
     * @Then I should get an error
     * @Then I should get an error response
     */
    public function shouldGetAnError()
    {
        if (!$this->client->lastResponseHasErrors()) {
            throw ValidResponseException::withValue($lastResponse);
        }
    }

    /**
     * @Then I should get a not found error
     */
    public function shouldGetANotFoundError()
    {
        return 404 === $this->client->getLastResponseCode();
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
