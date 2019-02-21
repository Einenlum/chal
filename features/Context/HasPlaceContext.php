<?php

declare(strict_types=1);

namespace Context;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

trait HasPlaceContext
{
    private $placeContext;

    /**
     * @BeforeScenario
     */
    public function setPlaceContext(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $context = $environment->getContext(PlaceContext::class);

        $this->placeContext = $context;
    }
}
