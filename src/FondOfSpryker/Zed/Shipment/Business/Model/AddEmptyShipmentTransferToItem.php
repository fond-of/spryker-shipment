<?php

namespace FondOfSpryker\Zed\Shipment\Business\Model;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;

class AddEmptyShipmentTransferToItem
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function prepare(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        foreach ($cartChangeTransfer->getItems() as $itemTransfer) {
            if ($itemTransfer->getShipment() === null) {
                $itemTransfer->setShipment(new ShipmentTransfer());
            }
        }

        return $cartChangeTransfer;
    }
}
