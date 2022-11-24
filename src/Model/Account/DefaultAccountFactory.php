<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Account;

use Inspirum\Balikobot\Model\Carrier\CarrierFactory;

final class DefaultAccountFactory implements AccountFactory
{
    private CarrierFactory $carrierFactory;

    public function __construct(CarrierFactory $carrierFactory)
    {
        $this->carrierFactory = $carrierFactory;
    }

    /** @inheritDoc */
    public function create(array $response): Account
    {
        return new DefaultAccount($response['account']['name'], $response['account']['contact_person'], $response['account']['email'], $response['account']['phone'], $response['account']['url'], $response['account']['street'], $response['account']['city'], $response['account']['zip'], $response['account']['country'], $response['live_account'], $this->carrierFactory->createCollection($response));
    }
}
