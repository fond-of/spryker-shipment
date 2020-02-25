<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator;
use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use FondOfSpryker\Zed\Shipment\ShipmentDependencyProvider;
use Spryker\Zed\Shipment\Business\Model\CalculatorInterface;
use Spryker\Zed\Shipment\Business\ShipmentBusinessFactory as SprykerShipmentBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Shipment\Persistence\ShipmentQueryContainer getQueryContainer()
 */
class ShipmentBusinessFactory extends SprykerShipmentBusinessFactory
{
    /**
     * @return \Spryker\Zed\Shipment\Business\Model\CalculatorInterface
     */
    public function createShipmentTaxCalculator(): CalculatorInterface
    {
        return new ShipmentTaxRateCalculator(
            $this->getQueryContainer(),
            $this->getTaxFacade(),
            $this->getCountryFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface
     */
    protected function getCountryFacade(): ShipmentToCountryFacadeInterface
    {
        return $this->getProvidedDependency(ShipmentDependencyProvider::FACADE_COUNTRY);
    }
}
