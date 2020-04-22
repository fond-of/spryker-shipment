<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use Generated\Shared\Transfer\CartChangeTransfer;
use Spryker\Zed\Shipment\Business\ShipmentFacade as SprykerShipmentFacade;

/**
 * @method \FondOfSpryker\Zed\Shipment\Business\ShipmentBusinessFactory getFactory()
 * @method \Spryker\Zed\Shipment\Persistence\ShipmentEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Shipment\Persistence\ShipmentRepositoryInterface getRepository()
 */
class ShipmentFacade extends SprykerShipmentFacade implements ShipmentFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function prepareAndSetEmptyShipment(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        return $this->getFactory()->createAddEmptyShipmentTransferToItem()->prepare($cartChangeTransfer);
    }
}
