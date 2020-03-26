<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use FondOfSpryker\Zed\Shipment\Business\Model\AddEmptyShipmentTransferToItem;
use FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator;
use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use FondOfSpryker\Zed\Shipment\ShipmentDependencyProvider;
use Spryker\Zed\Shipment\Business\Model\CalculatorInterface;
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
            $this->getRepository(),
            $this->getQueryContainer(),
            $this->getTaxFacade(),
            $this->getShipmentService(),
            $this->getCountryFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Shipment\Business\Model\AddEmptyShipmentTransferToItem
     */
    public function createAddEmptyShipmentTransferToItem(): AddEmptyShipmentTransferToItem
    {
        return new AddEmptyShipmentTransferToItem();
    }

    /**
     * @return \FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface
     */
    protected function getCountryFacade(): ShipmentToCountryFacadeInterface
    {
        return $this->getProvidedDependency(ShipmentDependencyProvider::FACADE_COUNTRY);
    }
}
