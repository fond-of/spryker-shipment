<?php

namespace FondOfSpryker\Yves\Shipment;

use Spryker\Yves\Shipment\ShipmentConfig as SprykerShipmentConfig;

class ShipmentConfig extends SprykerShipmentConfig
{
    const DEFAULT_SHIPMENT_METHOD_ID = 'DEFAULT_SHIPMENT_METHOD_ID';

    const DEFAULT_MODULE_SHIPMENT_METHOD_ID = 1;

    public function getDefaultShipmentMethodId(): int
    {
        return $this->get(self::DEFAULT_SHIPMENT_METHOD_ID, self::DEFAULT_MODULE_SHIPMENT_METHOD_ID);
    }
}
