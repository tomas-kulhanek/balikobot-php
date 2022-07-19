<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Status;

use DateTimeImmutable;
use Inspirum\Balikobot\Client\Request\CarrierType;
use Inspirum\Balikobot\Client\Response\Validator;
use Inspirum\Balikobot\Exception\BadRequestException;
use Throwable;
use function array_key_exists;
use function array_map;
use function assert;
use function count;
use function is_array;
use function is_string;

final class DefaultPackageStatusFactory implements PackageStatusFactory
{
    public function __construct(
        private Validator $validator,
    ) {
    }

    /** @inheritDoc */
    public function create(CarrierType $carrier, string $carrierId, array $data, array $response = []): Status
    {
        try {
            return new Status(
                $carrier,
                $carrierId,
                (float) ($data['status_id_v2'] ?? $data['status_id']),
                (string) ($data['name_balikobot'] ?? ($data['name_internal'] ?? $data['name'])),
                (string) $data['name'],
                (string) ($data['type'] ?? 'event'),
                array_key_exists('date', $data) ? new DateTimeImmutable((string) $data['date']) : null,
            );
        } catch (Throwable $exception) {
            throw new BadRequestException($response, previous: $exception);
        }
    }

    /** @inheritDoc */
    public function createLastStatus(CarrierType $carrier, array $data, array $response = []): Status
    {
        $this->validator->validateResponseStatus($data, $response);

        try {
            return new Status(
                $carrier,
                (string) $data['carrier_id'],
                (float) $data['status_id'],
                (string) $data['status_text'],
                (string) $data['status_text'],
                'event',
                null,
            );
        } catch (Throwable $exception) {
            throw new BadRequestException($response, previous: $exception);
        }
    }

    /** @inheritDoc */
    public function createCollection(CarrierType $carrier, array $carrierIds, array $data): StatusesCollection
    {
        $packages = $data['packages'] ?? [];
        $this->validator->validateIndexes($packages, count($carrierIds));

        $statuses = new StatusesCollection($carrier, array_map(
            fn(array $status): Statuses => $this->createStatuses($carrier, $status, $data),
            $packages,
        ));

        return $statuses;
    }

    /**
     * @param array<string,string|int|array<string,string|int|float|array<string|mixed>>> $data
     * @param array<mixed,mixed>                                                          $response
     *
     * @throws \Inspirum\Balikobot\Exception\Exception
     */
    private function createStatuses(CarrierType $carrier, array $data, array $response = []): Statuses
    {
        $this->validator->validateResponseStatus($data, $response);
        assert(is_string($data['carrier_id']));
        assert(is_array($data['states'] ?? []));

        return new Statuses(
            $carrier,
            (string) $data['carrier_id'],
            array_map(
                fn(array $status): Status => $this->create($carrier, (string) $data['carrier_id'], $status, $response),
                $data['states'] ?? [],
            ),
        );
    }

    /** @inheritDoc */
    public function createLastStatusCollection(CarrierType $carrier, array $carrierIds, array $data): StatusCollection
    {
        $packages = $data['packages'] ?? [];
        $this->validator->validateIndexes($packages, count($carrierIds));

        $statuses = new StatusCollection($carrier, array_map(
            fn(array $status): Status => $this->createLastStatus($carrier, $status, $data),
            $packages,
        ));

        return $statuses;
    }
}
