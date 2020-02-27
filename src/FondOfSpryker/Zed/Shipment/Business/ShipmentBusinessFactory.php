<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator;
use FondOfSpryker\Zed\Shipment\ShipmentDependencyProvider;
use Spryker\Zed\Shipment\Business\ShipmentBusinessFactory as SprykerShipmentBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface getQueryContainer()
 */
class ShipmentBusinessFactory extends SprykerShipmentBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator
     */
    public function createShipmentTaxCalculator()
    {
        return new ShipmentTaxRateCalculator(
            $this->getQueryContainer(),
            $this->getTaxFacade(),
            $this->getShipmentService(),
            $this->getCountryFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected function getCountryFacade()
    {
        return $this->getProvidedDependency(ShipmentDependencyProvider::FACADE_COUNTRY);
    }
}
