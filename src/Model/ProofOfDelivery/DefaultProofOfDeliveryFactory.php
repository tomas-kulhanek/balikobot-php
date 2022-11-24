<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\ProofOfDelivery;

use Inspirum\Balikobot\Client\Response\Validator;
use function count;

final class DefaultProofOfDeliveryFactory implements ProofOfDeliveryFactory
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /** @inheritDoc */
    public function create(array $carrierIds, array $data): array
    {
        unset($data['status']);
        $this->validator->validateIndexes($data, count($carrierIds));

        $fileUrls = [];
        foreach ($data as $item) {
            $this->validator->validateResponseStatus($item, $data);

            $fileUrls[] = $item['file_url'];
        }

        return $fileUrls;
    }
}
