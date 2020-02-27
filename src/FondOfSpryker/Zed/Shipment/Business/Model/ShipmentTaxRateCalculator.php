<?php

namespace FondOfSpryker\Zed\Shipment\Business\Model;

use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;
use FondOfSpryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Service\Shipment\ShipmentServiceInterface;
use Spryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator as SprykerShipmentTaxRateCalculator;
use Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface;

class ShipmentTaxRateCalculator extends SprykerShipmentTaxRateCalculator
{
    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @param \FondOfSpryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface $shipmentQueryContainer
     * @param \Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface $taxFacade
     * @param \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface $countryFacade
     */
    public function __construct(
        ShipmentQueryContainerInterface $shipmentQueryContainer,
        ShipmentToTaxInterface $taxFacade,
        ShipmentServiceInterface $shipmentService,
        CountryFacadeInterface $countryFacade
    ) {
        parent::__construct($shipmentQueryContainer, $taxFacade, $shipmentService);
        $this->countryFacade = $countryFacade;
        $this->shipmentQueryContainer = $shipmentQueryContainer;
        $this->taxFacade = $taxFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Orm\Zed\Shipment\Persistence\SpyShipmentMethod|null
     */
    protected function findTaxSet(QuoteTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getShippingAddress()->getRegion()) {
            $countryIso2Code = $this->getCountryIso2Code($quoteTransfer);
            $idRegion = $this->countryFacade->getIdRegionByIso2Code($quoteTransfer->getShippingAddress()->getRegion());

            return $this->shipmentQueryContainer->queryTaxSetByIdShipmentMethodCountryIso2CodeAndRegionId(
                $quoteTransfer->getShipment()->getMethod()->getIdShipmentMethod(),
                $countryIso2Code,
                $idRegion
            )->findOne();
        }

        return parent::findTaxSet($quoteTransfer);
    }
}
