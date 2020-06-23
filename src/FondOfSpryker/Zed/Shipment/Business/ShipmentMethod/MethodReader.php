<?php

namespace FondOfSpryker\Zed\Shipment\Business\ShipmentMethod;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentGroupTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Spryker\Zed\Shipment\Business\ShipmentMethod\MethodReader as SprykerMethodReader;

class MethodReader extends SprykerMethodReader
{
    /**
     * @param int $idShipmentMethod
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ShipmentMethodTransfer|null
     */
    public function findAvailableMethodById(int $idShipmentMethod, QuoteTransfer $quoteTransfer): ?ShipmentMethodTransfer
    {
        $idStore = $this->getIdStoreFromQuote($quoteTransfer);
        $shipmentMethodTransfer = $this->shipmentRepository->findShipmentMethodByIdAndIdStore($idShipmentMethod, $idStore);
        if ($shipmentMethodTransfer === null) {
            return null;
        }

        $shipmentGroupTransfer = (new ShipmentGroupTransfer())
            ->setShipment((new ShipmentTransfer())
                ->setMethod($shipmentMethodTransfer)
                ->setShippingAddress($quoteTransfer->getShippingAddress()))
            ->setItems($quoteTransfer->getItems());
        $storeCurrencyPrice = $this->methodPriceReader
            ->findShipmentGroupShippingPrice($shipmentMethodTransfer, $quoteTransfer, $shipmentGroupTransfer);
        if ($storeCurrencyPrice === null) {
            return null;
        }

        return $this->transformShipmentMethod($quoteTransfer, $shipmentMethodTransfer, $storeCurrencyPrice);
    }
}
