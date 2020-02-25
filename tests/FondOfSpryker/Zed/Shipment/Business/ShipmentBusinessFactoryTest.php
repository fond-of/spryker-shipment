<?php

namespace FondOfSpryker\Zed\Shipment\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Shipment\Business\Model\ShipmentTaxRateCalculator;
use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use FondOfSpryker\Zed\Shipment\Persistence\ShipmentQueryContainer;
use FondOfSpryker\Zed\Shipment\ShipmentDependencyProvider;
use Pimple;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface;

class ShipmentBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Shipment\Business\ShipmentBusinessFactory
     */
    protected $shipmentBusinessFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\FondOfSpryker\Zed\Shipment\Persistence\ShipmentQueryContainer
     */
    protected $queryContainerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface
     */
    protected $taxFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->taxFacadeMock = $this->getMockBuilder(ShipmentToTaxInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(ShipmentToCountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerMock = $this->getMockBuilder(ShipmentQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentBusinessFactory = new ShipmentBusinessFactory();
        $this->shipmentBusinessFactory->setContainer($this->containerMock);
        $this->shipmentBusinessFactory->setQueryContainer($this->queryContainerMock);
    }

    /**
     * @return void
     */
    public function testCreateShipmentTaxCalculator(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method($this->containerMock instanceof Pimple ? 'offsetExists' : 'has')
            ->willReturnMap([
                [
                    ShipmentDependencyProvider::FACADE_TAX,
                    true,
                ],
                [
                    ShipmentDependencyProvider::FACADE_COUNTRY,
                    true,
                ],
            ]);

        $this->containerMock->expects($this->atLeastOnce())
            ->method($this->containerMock instanceof Pimple ? 'offsetGet' : 'get')
            ->willReturnMap([
                [
                    ShipmentDependencyProvider::FACADE_TAX,
                    $this->taxFacadeMock,
                ],
                [
                    ShipmentDependencyProvider::FACADE_COUNTRY,
                    $this->countryFacadeMock,
                ],
            ]);

        $shipmentTaxCalculator = $this->shipmentBusinessFactory->createShipmentTaxCalculator();

        $this->assertInstanceOf(ShipmentTaxRateCalculator::class, $shipmentTaxCalculator);
    }
}
