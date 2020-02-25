<?php

namespace FondOfSpryker\Zed\Shipment\Business\Model;

use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Shipment\Persistence\SpyShipmentMethod;
use Spryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator as SprykerShipmentTaxRateCalculator;
use Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface;
use Spryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface;

class ShipmentTaxRateCalculator extends SprykerShipmentTaxRateCalculator
{
    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @param \Spryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface $shipmentQueryContainer
     * @param \Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface $taxFacade
     * @param \FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface $countryFacade
     */
    public function __construct(
        ShipmentQueryContainerInterface $shipmentQueryContainer,
        ShipmentToTaxInterface $taxFacade,
        ShipmentToCountryFacadeInterface $countryFacade
    ) {
        parent::__construct($shipmentQueryContainer, $taxFacade);

        $this->countryFacade = $countryFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Orm\Zed\Shipment\Persistence\SpyShipmentMethod|null
     */
    protected function findTaxSet(QuoteTransfer $quoteTransfer): ?SpyShipmentMethod
    {
        $shippingAddressTransfer = $quoteTransfer->getShippingAddress();

        if ($shippingAddressTransfer === null || $shippingAddressTransfer->getRegion() === null) {
            return parent::findTaxSet($quoteTransfer);
        }

        $shipmentTransfer = $quoteTransfer->getShipment();

        if ($shipmentTransfer === null || $shipmentTransfer->getMethod() === null) {
            return parent::findTaxSet($quoteTransfer);
        }

        $countryIso2Code = $this->getCountryIso2Code($quoteTransfer);
        $idRegion = $this->countryFacade->getIdRegionByIso2Code($shippingAddressTransfer->getRegion());

        return $this->shipmentQueryContainer->queryTaxSetByIdShipmentMethodCountryIso2CodeAndRegionId(
            $shipmentTransfer->getMethod()->getIdShipmentMethod(),
            $countryIso2Code,
            $idRegion
        )->findOne();
    }
}
