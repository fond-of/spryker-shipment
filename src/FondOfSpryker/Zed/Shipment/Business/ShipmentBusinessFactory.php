<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use FondOfSpryker\Zed\Shipment\Business\Model\AddEmptyShipmentTransferToItem;
use FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator as FondOfSprykerShipmentTaxRateCalculator;
use FondOfSpryker\Zed\Shipment\Business\ShipmentMethod\MethodPriceReader;
use FondOfSpryker\Zed\Shipment\Business\ShipmentMethod\MethodReader;
use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use FondOfSpryker\Zed\Shipment\ShipmentDependencyProvider;
use Spryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator as SprykerShipmentTaxRateCalculator;
use Spryker\Zed\Shipment\Business\ShipmentBusinessFactory as SprykerShipmentBusinessFactory;
use Spryker\Zed\Shipment\Business\ShipmentMethod\MethodPriceReaderInterface;
use Spryker\Zed\Shipment\Business\ShipmentMethod\MethodReaderInterface;

/**
 * @method \Spryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Shipment\Persistence\ShipmentEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Shipment\ShipmentConfig getConfig()
 * @method \Spryker\Zed\Shipment\Persistence\ShipmentRepositoryInterface getRepository()
 */
class ShipmentBusinessFactory extends SprykerShipmentBusinessFactory
{
    /**
     * @return \Spryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator|\FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator
     */
    public function createShipmentTaxCalculator(): SprykerShipmentTaxRateCalculator|FondOfSprykerShipmentTaxRateCalculator
    {
        return new FondOfSprykerShipmentTaxRateCalculator(
            $this->getRepository(),
            $this->getQueryContainer(),
            $this->getTaxFacade(),
            $this->getShipmentService(),
            $this->getCountryFacade(),
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
            $this->getStoreFacade(),
            $this->createShipmentMethodExpander(),
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
            $this->getCurrencyFacade(),
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
