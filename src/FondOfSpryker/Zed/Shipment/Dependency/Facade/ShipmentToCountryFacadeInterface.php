<?php

namespace FondOfSpryker\Zed\Shipment\Dependency\Facade;

interface ShipmentToCountryFacadeInterface
{
    /**
     * @param string $iso2code
     *
     * @return int
     */
    public function getIdRegionByIso2Code(string $iso2code): int;
}
