<?php

namespace FondOfSpryker\Yves\Shipment;

use Spryker\Shared\Shipment\ShipmentConfig as SprykerShipmentConfig;

class ShipmentConfig extends SprykerShipmentConfig
{
    /**
     * @var string
     */
    public const DEFAULT_SHIPMENT_METHOD_ID = 'DEFAULT_SHIPMENT_METHOD_ID';

    /**
     * @var int
     */
    public const DEFAULT_MODULE_SHIPMENT_METHOD_ID = 1;

    /**
     * @return int
     */
    public function getDefaultShipmentMethodId(): int
    {
        return $this->get(static::DEFAULT_SHIPMENT_METHOD_ID, static::DEFAULT_MODULE_SHIPMENT_METHOD_ID);
    }
}
