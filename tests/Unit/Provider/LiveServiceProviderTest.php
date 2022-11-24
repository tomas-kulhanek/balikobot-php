<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Tests\Unit\Provider;

use Inspirum\Balikobot\Definitions\Carrier;
use Inspirum\Balikobot\Definitions\Service;
use Inspirum\Balikobot\Model\Service\DefaultService;
use Inspirum\Balikobot\Model\Service\DefaultServiceCollection;
use Inspirum\Balikobot\Provider\LiveServiceProvider;
use Inspirum\Balikobot\Service\SettingService;
use Inspirum\Balikobot\Tests\Unit\BaseTestCase;
use function array_map;

final class LiveServiceProviderTest extends BaseTestCase
{
    public function testGetServices(): void
    {
        $carrier          = Carrier::DPD;
        $expectedServices = [
            Service::DPD_CLASSIC,
            Service::DPD_EXPRESS_12,
            Service::DPD_EXPRESS_18,
        ];

        $settingService = $this->createMock(SettingService::class);
        $settingService->expects(self::once())->method('getServices')->with($carrier)->willReturn(
            new DefaultServiceCollection($carrier, array_map(static function (string $service) {
                return new DefaultService($service, null);
            }, $expectedServices)),
        );

        $provider = $this->newLiveServiceProvider($settingService);

        $services = $provider->getServices($carrier);

        self::assertSame($expectedServices, $services);
    }

    private function newLiveServiceProvider(SettingService $settingService): LiveServiceProvider
    {
        return new LiveServiceProvider($settingService);
    }
}
