<?php

namespace FondOfSpryker\Zed\Shipment\Business\Model;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator as SprykerShipmentTaxCalculator;

class ShipmentTaxRateCalculator extends SprykerShipmentTaxCalculator
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Orm\Zed\Shipment\Persistence\SpyShipmentMethod|null
     */
    protected function findTaxSet(QuoteTransfer $quoteTransfer)
    {
        $countryIso2Code = $this->getCountryIso2Code($quoteTransfer);

        return $this->shipmentQueryContainer->queryTaxSetByIdShipmentMethodCountryIso2CodeAndRegion(
            $quoteTransfer->getShipment()->getMethod()->getIdShipmentMethod(),
            $countryIso2Code,
            $quoteTransfer->getShippingAddress()->getFkRegion()
        )->findOne();
    }

}
