<?php

namespace FondOfSpryker\Zed\Shipment\Business\ShipmentMethod;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentGroupTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Spryker\Zed\Shipment\Business\ShipmentMethod\MethodPriceReader as SprykerMethodPriceReader;

class MethodPriceReader extends SprykerMethodPriceReader
{
    /**
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer $shipmentMethodTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\ShipmentGroupTransfer|null $shipmentGroupTransfer
     *
     * @return int|null
     */
    public function findShipmentGroupShippingPrice(
        ShipmentMethodTransfer $shipmentMethodTransfer,
        QuoteTransfer $quoteTransfer,
        ?ShipmentGroupTransfer $shipmentGroupTransfer = null
    ): ?int {
        if (!$this->isSetPricePlugin($shipmentMethodTransfer)) {
            return $this->findShipmentMethodPriceValue($shipmentMethodTransfer, $quoteTransfer);
        }

        if ($shipmentGroupTransfer === null) {
            $pricePlugin = $this->getPricePlugin($shipmentMethodTransfer);

            return $pricePlugin->getPrice($quoteTransfer);
        }

        return $this->getPricePluginValue($shipmentMethodTransfer, $shipmentGroupTransfer, $quoteTransfer);
    }
}
