<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\ZipCode;

use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultZipCode extends BaseModel implements ZipCode
{
    private string $carrier;
    private ?string $service;
    private ?string $zipCode;
    private ?string $zipCodeEnd;
    private ?string $city;
    private ?string $region;
    private ?string $country;
    private bool $morningDelivery;

    public function __construct(string $carrier, ?string $service, ?string $zipCode, ?string $zipCodeEnd, ?string $city, ?string $region, ?string $country, bool $morningDelivery)
    {
        $this->carrier         = $carrier;
        $this->service         = $service;
        $this->zipCode         = $zipCode;
        $this->zipCodeEnd      = $zipCodeEnd;
        $this->city            = $city;
        $this->region          = $region;
        $this->country         = $country;
        $this->morningDelivery = $morningDelivery;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function getZipCodeEnd(): ?string
    {
        return $this->zipCodeEnd;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function isMorningDelivery(): bool
    {
        return $this->morningDelivery;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'carrier'         => $this->carrier,
            'service'         => $this->service,
            'zipCode'         => $this->zipCode,
            'zipCodeEnt'      => $this->zipCodeEnd,
            'city'            => $this->city,
            'region'          => $this->region,
            'country'         => $this->country,
            'morningDelivery' => $this->morningDelivery,
        ];
    }
}
