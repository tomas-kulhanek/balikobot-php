<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\OrderedShipment;

use Inspirum\Balikobot\Client\Request\CarrierType;

final class DefaultOrderedShipmentFactory implements OrderedShipmentFactory
{
    /** @inheritDoc */
    public function create(CarrierType $carrier, array $packageIds, array $data): OrderedShipment
    {
        return new OrderedShipment(
            $data['order_id'],
            $carrier,
            $packageIds,
            $data['handover_url'],
            $data['labels_url'],
            $data['file_url'] ?? null
        );
    }
}
