<?php

namespace FondOfSpryker\Zed\Shipment\Business\Model;

use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use Generated\Shared\Transfer\ShipmentTransfer;
use Generated\Shared\Transfer\TaxSetTransfer;
use Spryker\Service\Shipment\ShipmentServiceInterface;
use Spryker\Zed\Shipment\Business\Calculator\ShipmentTaxRateCalculator as SprykerShipmentTaxRateCalculator;
use Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface;
use Spryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface;
use Spryker\Zed\Shipment\Persistence\ShipmentRepositoryInterface;

class ShipmentTaxRateCalculator extends SprykerShipmentTaxRateCalculator
{
    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @var \FondOfSpryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface
     */
    protected $shipmentQueryContainer;

    /**
     * @param \Spryker\Zed\Shipment\Persistence\ShipmentRepositoryInterface $shipmentRepository
     * @param \Spryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface $shipmentQueryContainer
     * @param \Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface $taxFacade
     * @param \Spryker\Service\Shipment\ShipmentServiceInterface $shipmentService
     * @param \FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface $countryFacade
     */
    public function __construct(
        ShipmentRepositoryInterface $shipmentRepository,
        ShipmentQueryContainerInterface $shipmentQueryContainer,
        ShipmentToTaxInterface $taxFacade,
        ShipmentServiceInterface $shipmentService,
        ShipmentToCountryFacadeInterface $countryFacade
    ) {
        parent::__construct($shipmentRepository, $taxFacade, $shipmentService);
        $this->countryFacade = $countryFacade;
        $this->shipmentQueryContainer = $shipmentQueryContainer;
        $this->taxFacade = $taxFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ShipmentTransfer $shipmentTransfer
     *
     * @return \Generated\Shared\Transfer\TaxSetTransfer|null
     */
    protected function findTaxSet(ShipmentTransfer $shipmentTransfer): ?TaxSetTransfer
    {
        $addressTransfer = $shipmentTransfer->getShippingAddress();

        if ($addressTransfer !== null && $addressTransfer->getRegion()) {
            $countryIso2Code = $this->getCountryIso2Code($addressTransfer);
            $idRegion = $this->countryFacade->getIdRegionByIso2Code($countryIso2Code);

            $tax = $this->shipmentQueryContainer->queryTaxSetByIdShipmentMethodCountryIso2CodeAndRegionId(
                $shipmentTransfer->getMethod()->getIdShipmentMethod(),
                $countryIso2Code,
                $idRegion
            )->findOne();

            if ($tax !== null) {
                $taxTransfer = new TaxSetTransfer();
                $taxTransfer->fromArray($tax->toArray(), true);

                return $taxTransfer;
            }
        }

        return parent::findTaxSet($shipmentTransfer);
    }
}
