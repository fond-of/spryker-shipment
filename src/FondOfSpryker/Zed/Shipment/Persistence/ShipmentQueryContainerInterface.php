<?php

namespace FondOfSpryker\Zed\Shipment\Persistence;

use Orm\Zed\Shipment\Persistence\SpyShipmentMethodQuery;
use Spryker\Zed\Shipment\Persistence\ShipmentQueryContainerInterface as SprykerShipmentQueryContainerInterface;

interface ShipmentQueryContainerInterface extends SprykerShipmentQueryContainerInterface
{
    /**
     * @param int $idShipmentMethod
     * @param string $countryIso2Code
     * @param int $idRegion
     *
     * @return \Orm\Zed\Shipment\Persistence\SpyShipmentMethodQuery
     */
    public function queryTaxSetByIdShipmentMethodCountryIso2CodeAndRegionId(
        $idShipmentMethod,
        $countryIso2Code,
        $idRegion
    ): SpyShipmentMethodQuery;
}
