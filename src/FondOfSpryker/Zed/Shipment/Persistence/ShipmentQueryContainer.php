<?php

namespace FondOfSpryker\Zed\Shipment\Persistence;

use Orm\Zed\Shipment\Persistence\SpyShipmentMethodQuery;
use Orm\Zed\Tax\Persistence\Map\SpyTaxRateTableMap;
use Orm\Zed\Tax\Persistence\Map\SpyTaxSetTableMap;
use Spryker\Shared\Tax\TaxConstants;
use Spryker\Zed\Shipment\Persistence\ShipmentQueryContainer as SprykerShipmentQueryContainer;

/**
 * @method \Spryker\Zed\Shipment\Persistence\ShipmentPersistenceFactory getFactory()
 */
class ShipmentQueryContainer extends SprykerShipmentQueryContainer implements ShipmentQueryContainerInterface
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
    ): SpyShipmentMethodQuery {
        // @phpstan-ignore-next-line
        return $this->getFactory()->createShipmentMethodQuery()
            ->filterByIdShipmentMethod($idShipmentMethod)
            ->useTaxSetQuery()
                ->useSpyTaxSetTaxQuery()
                    ->useSpyTaxRateQuery()
                        ->useCountryQuery()
                            ->filterByIso2Code($countryIso2Code)
                        ->endUse()
                        ->_and()
                        ->useSpyRegionQuery()
                            ->filterByIdRegion($idRegion)
                        ->endUse()
                        ->_or()
                        ->filterByName(TaxConstants::TAX_EXEMPT_PLACEHOLDER)
                    ->endUse()
                ->endUse()
                ->withColumn(SpyTaxSetTableMap::COL_NAME)
                ->groupBy(SpyTaxSetTableMap::COL_NAME)
                ->withColumn('MAX(' . SpyTaxRateTableMap::COL_RATE . ')', self::COL_MAX_TAX_RATE)
            ->endUse()
            ->select([self::COL_MAX_TAX_RATE]);
    }
}
