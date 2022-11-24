<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Carrier;

use Inspirum\Balikobot\Definitions\Version;
use Inspirum\Balikobot\Model\Method\MethodFactory;
use function array_filter;
use function array_map;

final class DefaultCarrierFactory implements CarrierFactory
{
    private MethodFactory $methodFactory;

    public function __construct(MethodFactory $methodFactory)
    {
        $this->methodFactory = $methodFactory;
    }

    /** @inheritDoc */
    public function create(string $carrier, array $data): Carrier
    {
        return new DefaultCarrier($carrier, $data['name'], array_map(fn(array $methods) => $this->methodFactory->createCollection($methods), array_filter([
            Version::V2V1 => $data['methods'] ?? [],
            Version::V2V2 => $data['v2_methods'] ?? [],
        ])));
    }

    /** @inheritDoc */
    public function createCollection(array $data): CarrierCollection
    {
        return new DefaultCarrierCollection(array_map(fn(array $carrier): Carrier => $this->create($carrier['slug'], $carrier), $data['carriers']));
    }
}
