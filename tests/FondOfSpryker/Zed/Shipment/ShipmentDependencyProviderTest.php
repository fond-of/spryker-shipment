<?php

namespace FondOfSpryker\Zed\Shipment;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;
use FondOfSpryker\Zed\Shipment\Dependency\Facade\ShipmentToCountryFacadeInterface;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Sales\Business\SalesFacadeInterface;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;
use Spryker\Zed\Shipment\Dependency\Facade\ShipmentToCurrencyInterface;
use Spryker\Zed\Shipment\Dependency\Facade\ShipmentToSalesFacadeBridge;
use Spryker\Zed\Shipment\Dependency\Facade\ShipmentToStoreInterface;
use Spryker\Zed\Shipment\Dependency\ShipmentToTaxInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use Spryker\Zed\Tax\Business\TaxFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ShipmentDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Shipment\ShipmentDependencyProvider
     */
    protected $shipmentDependencyProvider;

    /**
     * @var \Spryker\Zed\Kernel\Locator|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Locator|MockObject $locatorMock;

    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Container|MockObject $containerMock;

    /**
     * @var \Spryker\Shared\Kernel\BundleProxy|\PHPUnit\Framework\MockObject\MockObject
     */
    protected BundleProxy|MockObject $bundleProxyMock;

    /**
     * @var \Spryker\Zed\Tax\Business\TaxFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected TaxFacadeInterface|MockObject $taxFacadeMock;

    /**
     * @var \Spryker\Zed\Currency\Business\CurrencyFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CurrencyFacadeInterface|MockObject $currencyFacadeMock;

    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreFacadeInterface|MockObject $storeFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CountryFacadeInterface|MockObject $countryFacadeMock;

    /**
     * @var MockObject|\Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected SalesQueryContainerInterface|MockObject $salesQueryContainerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->taxFacadeMock = $this->getMockBuilder(TaxFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyFacadeMock = $this->getMockBuilder(CurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(StoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(CountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesQueryContainerMock = $this->getMockBuilder(SalesQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentDependencyProvider = new ShipmentDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->exactly(5))
            ->method('__call')
            ->withConsecutive(['sales'], ['tax'], ['currency'], ['store'], ['country'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->exactly(5))
            ->method('__call')
            ->withConsecutive(['facade'], ['facade'], ['facade'], ['facade'], ['facade'])
            ->willReturnOnConsecutiveCalls(
                $this->salesQueryContainerMock,
                $this->taxFacadeMock,
                $this->currencyFacadeMock,
                $this->storeFacadeMock,
                $this->countryFacadeMock
            );

        $this->shipmentDependencyProvider->provideBusinessLayerDependencies($this->containerMock);

        $this->assertInstanceOf(
            ShipmentToSalesFacadeBridge::class,
            $this->containerMock[ShipmentDependencyProvider::FACADE_SALES]
        );

        $this->assertInstanceOf(
            ShipmentToTaxInterface::class,
            $this->containerMock[ShipmentDependencyProvider::FACADE_TAX]
        );

        $this->assertInstanceOf(
            ShipmentToCurrencyInterface::class,
            $this->containerMock[ShipmentDependencyProvider::FACADE_CURRENCY]
        );

        $this->assertInstanceOf(
            ShipmentToStoreInterface::class,
            $this->containerMock[ShipmentDependencyProvider::FACADE_STORE]
        );

        $this->assertInstanceOf(
            ShipmentToCountryFacadeInterface::class,
            $this->containerMock[ShipmentDependencyProvider::FACADE_COUNTRY]
        );
    }
}
