<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Tests\Unit\Service;

use Inspirum\Balikobot\Client\Client;
use Inspirum\Balikobot\Definitions\Carrier;
use Inspirum\Balikobot\Definitions\Country;
use Inspirum\Balikobot\Definitions\Method;
use Inspirum\Balikobot\Definitions\Service;
use Inspirum\Balikobot\Definitions\Version;
use Inspirum\Balikobot\Model\AdrUnit\AdrUnitCollection;
use Inspirum\Balikobot\Model\AdrUnit\AdrUnitFactory;
use Inspirum\Balikobot\Model\Attribute\AttributeCollection;
use Inspirum\Balikobot\Model\Attribute\AttributeFactory;
use Inspirum\Balikobot\Model\Carrier\Carrier as CarrierModel;
use Inspirum\Balikobot\Model\Carrier\CarrierCollection;
use Inspirum\Balikobot\Model\Carrier\CarrierFactory;
use Inspirum\Balikobot\Model\Country\CountryCollection;
use Inspirum\Balikobot\Model\Country\CountryFactory;
use Inspirum\Balikobot\Model\ManipulationUnit\ManipulationUnitCollection;
use Inspirum\Balikobot\Model\ManipulationUnit\ManipulationUnitFactory;
use Inspirum\Balikobot\Model\Service\Service as ServiceModel;
use Inspirum\Balikobot\Model\Service\ServiceCollection;
use Inspirum\Balikobot\Model\Service\ServiceFactory;
use Inspirum\Balikobot\Model\ZipCode\ZipCodeFactory;
use Inspirum\Balikobot\Model\ZipCode\ZipCodeIterator;
use Inspirum\Balikobot\Service\DefaultSettingService;
use function sprintf;

final class DefaultSettingServiceTest extends BaseServiceTestCase
{
    public function testGetCarriers(): void
    {
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(CarrierCollection::class);

        $infoService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, null, Method::INFO_CARRIERS], $response),
            $this->mockCarrierFactory(null, $response, $expectedResult),
        );

        $actualResult = $infoService->getCarriers();

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetCarrier(): void
    {
        $carrier        = Carrier::ZASILKOVNA;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(CarrierModel::class);

        $infoService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, null, Method::INFO_CARRIERS, [], $carrier], $response),
            $this->mockCarrierFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $infoService->getCarrier($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetServices(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ServiceCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::SERVICES], $response),
            null,
            $this->mockServiceFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getServices($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetActivatedServices(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ServiceCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::ACTIVATED_SERVICES], $response),
            null,
            $this->mockServiceFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getActivatedServices($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetB2AServices(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ServiceCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::B2A_SERVICES], $response),
            null,
            $this->mockServiceFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getB2AServices($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetManipulationUnits(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ManipulationUnitCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::MANIPULATION_UNITS], $response),
            null,
            null,
            $this->mockUnitFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getManipulationUnits($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetActivatedManipulationUnits(): void
    {
        $carrier        = Carrier::TOPTRANS;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ManipulationUnitCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::ACTIVATED_MANIPULATION_UNITS], $response),
            null,
            null,
            $this->mockUnitFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getActivatedManipulationUnits($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetCodCountries(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ServiceCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::CASH_ON_DELIVERY_COUNTRIES], $response),
            null,
            $this->mockServiceFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getCodCountries($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetCountries(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ServiceCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::COUNTRIES], $response),
            null,
            $this->mockServiceFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getCountries($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetCountriesData(): void
    {
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(CountryCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, null, Method::GET_COUNTRIES_DATA], $response),
            null,
            null,
            null,
            $this->mockCountryFactory($response, $expectedResult),
        );

        $actualResult = $settingService->getCountriesData();

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetZipCodes(): void
    {
        $carrier        = Carrier::CP;
        $serviceType    = Service::CP_DR;
        $country        = Country::CZECH_REPUBLIC;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ZipCodeIterator::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::ZIP_CODES, [], sprintf('%s/%s', $serviceType, $country)], $response),
            null,
            null,
            null,
            null,
            $this->mockZipCodeFactory($carrier, $serviceType, $country, $response, $expectedResult),
        );

        $actualResult = $settingService->getZipCodes($carrier, $serviceType, $country);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetAdrUnits(): void
    {
        $carrier        = Carrier::TOPTRANS;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(AdrUnitCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::FULL_ADR_UNITS], $response),
            null,
            null,
            null,
            null,
            null,
            $this->mockAdrUnitFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getAdrUnits($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetAddAttributes(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(AttributeCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::ADD_ATTRIBUTES], $response),
            null,
            null,
            null,
            null,
            null,
            null,
            $this->mockAttributeFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getAddAttributes($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetAddServiceOptions(): void
    {
        $carrier        = Carrier::CP;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ServiceCollection::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::ADD_SERVICE_OPTIONS], $response),
            null,
            $this->mockServiceFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getAddServiceOptions($carrier);

        self::assertSame($expectedResult, $actualResult);
    }

    public function testGetAddServiceOptionsForService(): void
    {
        $carrier        = Carrier::CP;
        $serviceType    = Service::CP_DR;
        $response       = $this->mockClientResponse();
        $expectedResult = $this->createMock(ServiceModel::class);

        $settingService = $this->newDefaultSettingService(
            $this->mockClient([Version::V2V1, $carrier, Method::ADD_SERVICE_OPTIONS, [], $serviceType], $response),
            null,
            $this->mockServiceFactory($carrier, $response, $expectedResult),
        );

        $actualResult = $settingService->getAddServiceOptionsForService($carrier, $serviceType);

        self::assertSame($expectedResult, $actualResult);
    }

    /**
     * @param array<string,mixed>                                                                           $data
     * @param \Inspirum\Balikobot\Model\Carrier\CarrierCollection|\Inspirum\Balikobot\Model\Carrier\Carrier $response
     */
    private function mockCarrierFactory(?string $carrier, array $data, $response): CarrierFactory
    {
        $carrierFactory = $this->createMock(CarrierFactory::class);
        $carrierFactory->expects(self::once())
            ->method($response instanceof CarrierModel ? 'create' : 'createCollection')
            ->with(...($response instanceof CarrierModel ? [$carrier, $data] : [$data]))
            ->willReturn($response);

        return $carrierFactory;
    }

    /**
     * @param array<string,mixed>                                                                           $data
     * @param \Inspirum\Balikobot\Model\Service\ServiceCollection|\Inspirum\Balikobot\Model\Service\Service $response
     */
    private function mockServiceFactory(string $carrier, array $data, $response): ServiceFactory
    {
        $serviceFactory = $this->createMock(ServiceFactory::class);
        $serviceFactory->expects(self::once())->method($response instanceof ServiceModel ? 'create' : 'createCollection')->with($carrier, $data)
            ->willReturn($response);

        return $serviceFactory;
    }

    /**
     * @param array<string,mixed> $data
     */
    private function mockUnitFactory(string $carrier, array $data, ManipulationUnitCollection $response): ManipulationUnitFactory
    {
        $manipulationUnitFactory = $this->createMock(ManipulationUnitFactory::class);
        $manipulationUnitFactory->expects(self::once())->method('createCollection')->with($carrier, $data)->willReturn($response);

        return $manipulationUnitFactory;
    }

    /**
     * @param array<string,mixed> $data
     */
    private function mockCountryFactory(array $data, CountryCollection $response): CountryFactory
    {
        $countryFactory = $this->createMock(CountryFactory::class);
        $countryFactory->expects(self::once())->method('createCollection')->with($data)->willReturn($response);

        return $countryFactory;
    }

    /**
     * @param array<string,mixed> $data
     */
    private function mockZipCodeFactory(
        string $carrier,
        string $service,
        ?string $country,
        array $data,
        ZipCodeIterator $response
    ): ZipCodeFactory {
        $zipCodeFactory = $this->createMock(ZipCodeFactory::class);
        $zipCodeFactory->expects(self::once())->method('createIterator')->with($carrier, $service, $country, $data)->willReturn($response);

        return $zipCodeFactory;
    }

    /**
     * @param array<string,mixed> $data
     */
    private function mockAdrUnitFactory(string $carrier, array $data, AdrUnitCollection $response): AdrUnitFactory
    {
        $adrUnitFactory = $this->createMock(AdrUnitFactory::class);
        $adrUnitFactory->expects(self::once())->method('createCollection')->with($carrier, $data)->willReturn($response);

        return $adrUnitFactory;
    }

    /**
     * @param array<string,mixed> $data
     */
    private function mockAttributeFactory(string $carrier, array $data, AttributeCollection $response): AttributeFactory
    {
        $attributeFactory = $this->createMock(AttributeFactory::class);
        $attributeFactory->expects(self::once())->method('createCollection')->with($carrier, $data)->willReturn($response);

        return $attributeFactory;
    }

    private function newDefaultSettingService(
        Client $client,
        ?CarrierFactory $carrierFactory = null,
        ?ServiceFactory $serviceFactory = null,
        ?ManipulationUnitFactory $unitFactory = null,
        ?CountryFactory $countryFactory = null,
        ?ZipCodeFactory $zipCodeFactory = null,
        ?AdrUnitFactory $adrUnitFactory = null,
        ?AttributeFactory $attributeFactory = null
    ): DefaultSettingService {
        return new DefaultSettingService(
            $client,
            $carrierFactory ?? $this->createMock(CarrierFactory::class),
            $serviceFactory ?? $this->createMock(ServiceFactory::class),
            $unitFactory ?? $this->createMock(ManipulationUnitFactory::class),
            $countryFactory ?? $this->createMock(CountryFactory::class),
            $zipCodeFactory ?? $this->createMock(ZipCodeFactory::class),
            $adrUnitFactory ?? $this->createMock(AdrUnitFactory::class),
            $attributeFactory ?? $this->createMock(AttributeFactory::class),
        );
    }
}
