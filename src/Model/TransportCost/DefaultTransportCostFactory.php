<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\TransportCost;

use Inspirum\Balikobot\Client\Response\Validator;
use function array_map;
use function array_values;
use function count;

final class DefaultTransportCostFactory implements TransportCostFactory
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /** @inheritDoc */
    public function create(string $carrier, array $data): TransportCost
    {
        return new DefaultTransportCost($data['eid'], $carrier, $data['costs_total'], $data['currency'], array_map(static fn(array $part) => new DefaultTransportCostPart($part['name'], $part['cost'], $data['currency']), $data['costs_breakdown'] ?? []));
    }

    /** @inheritDoc */
    public function createCollection(string $carrier, ?array $packages, array $data): TransportCostCollection
    {
        $packagesResponse = $data['packages'] ?? $data;

        if ($packages !== null) {
            $this->validator->validateIndexes($packagesResponse, count($packages));
        }

        $this->validator->validateResponseItemHasAttribute($packagesResponse, 'eid', $data);

        return new DefaultTransportCostCollection($carrier, array_values(array_map(fn(array $package): TransportCost => $this->create($carrier, $package), $packagesResponse)));
    }
}
