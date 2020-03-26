<?php

namespace FondOfSpryker\Zed\Shipment\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;

class ShipmentToCountryFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeBridge
     */
    protected $shipmentToCountryFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->countryFacadeMock = $this->getMockBuilder(CountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentToCountryFacadeBridge = new ShipmentToCountryFacadeBridge($this->countryFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetIdRegionByIso2Code(): void
    {
        $iso2Code = 'AL';
        $idRegion = 1;

        $this->countryFacadeMock->expects($this->atLeastOnce())
            ->method('getIdRegionByIso2Code')
            ->with($iso2Code)
            ->willReturn($idRegion);

        $this->assertEquals($idRegion, $this->shipmentToCountryFacadeBridge->getIdRegionByIso2Code($iso2Code));
    }
}
