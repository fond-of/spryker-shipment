<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use Generated\Shared\Transfer\CartChangeTransfer;
use Spryker\Zed\Shipment\Business\ShipmentFacadeInterface as SprykerShipmentFacadeInterface;

interface ShipmentFacadeInterface extends SprykerShipmentFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function prepareAndSetEmptyShipment(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer;
}
