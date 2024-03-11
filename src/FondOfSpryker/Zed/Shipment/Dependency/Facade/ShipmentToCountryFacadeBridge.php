<?php

namespace FondOfSpryker\Zed\Shipment\Dependency\Facade;

use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;

class ShipmentToCountryFacadeBridge implements ShipmentToCountryFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @param \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface $countryFacade
     */
    public function __construct(CountryFacadeInterface $countryFacade)
    {
        $this->countryFacade = $countryFacade;
    }

    /**
     * @param string $iso2code
     *
     * @return int
     */
    public function getIdRegionByIso2Code(string $iso2code): int
    {
        return $this->countryFacade->getIdRegionByIso2Code($iso2code);
    }
}
