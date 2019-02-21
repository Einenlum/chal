<?php

declare(strict_types=1);

namespace Context;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

trait HasClient
{
    private $client;

    /**
     * @BeforeScenario
     */
    public function setClient(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $context = $environment->getContext(ClientContext::class);

        $this->client = $context->getClient();
    }
}
