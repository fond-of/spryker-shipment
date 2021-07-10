<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use FondOfSpryker\Zed\Shipment\Business\Model\AddEmptyShipmentTransferToItem;
use FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator;
use FondOfSpryker\Zed\Shipment\Business\ShipmentMethod\MethodPriceReader;
use FondOfSpryker\Zed\Shipment\Business\ShipmentMethod\MethodReader;
use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use FondOfSpryker\Zed\Shipment\ShipmentDependencyProvider;
use Spryker\Zed\Shipment\Business\ShipmentBusinessFactory as SprykerShipmentBusinessFactory;
use Spryker\Zed\Shipment\Business\ShipmentMethod\MethodPriceReaderInterface;
use Spryker\Zed\Shipment\Business\ShipmentMethod\MethodReaderInterface;

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
     * @return \Spryker\Zed\Shipment\Business\ShipmentMethod\MethodReaderInterface
     */
    public function createMethodReader(): MethodReaderInterface
    {
        return new MethodReader(
            $this->getShipmentService(),
            $this->getMethodFilterPlugins(),
            $this->getRepository(),
            $this->createShipmentMethodAvailabilityChecker(),
            $this->createShipmentMethodPriceReader(),
            $this->createShipmentMethodDeliveryTimeReader(),
            $this->getStoreFacade()
        );
    }

    /**
     * @return \Spryker\Zed\Shipment\Business\ShipmentMethod\MethodPriceReaderInterface
     */
    public function createShipmentMethodPriceReader(): MethodPriceReaderInterface
    {
        return new MethodPriceReader(
            $this->getPricePlugins(),
            $this->getStoreFacade(),
            $this->getRepository(),
            $this->getCurrencyFacade()
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
