<?php

namespace FondOfSpryker\Yves\Shipment;

use Spryker\Yves\Shipment\ShipmentConfig as SprykerShipmentConfig;

class ShipmentConfig extends SprykerShipmentConfig
{
    public const DEFAULT_SHIPMENT_METHOD_ID = 'DEFAULT_SHIPMENT_METHOD_ID';
    public const DEFAULT_MODULE_SHIPMENT_METHOD_ID = 1;

    /**
     * @return int
     */
    public function getDefaultShipmentMethodId(): int
    {
        return $this->get(static::DEFAULT_SHIPMENT_METHOD_ID, static::DEFAULT_MODULE_SHIPMENT_METHOD_ID);
    }
}
