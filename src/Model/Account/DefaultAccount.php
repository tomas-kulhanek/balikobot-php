<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Account;

use Inspirum\Arrayable\BaseModel;
use Inspirum\Balikobot\Model\Carrier\CarrierCollection;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultAccount extends BaseModel implements Account
{
    private string $name;
    private string $contactPerson;
    private string $email;
    private string $phone;
    private string $url;
    private string $street;
    private string $city;
    private string $zip;
    private string $country;
    private bool $live;
    private CarrierCollection $carriers;

    public function __construct(string $name, string $contactPerson, string $email, string $phone, string $url, string $street, string $city, string $zip, string $country, bool $live, CarrierCollection $carriers)
    {
        $this->name          = $name;
        $this->contactPerson = $contactPerson;
        $this->email         = $email;
        $this->phone         = $phone;
        $this->url           = $url;
        $this->street        = $street;
        $this->city          = $city;
        $this->zip           = $zip;
        $this->country       = $country;
        $this->live          = $live;
        $this->carriers      = $carriers;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContactPerson(): string
    {
        return $this->contactPerson;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zip;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function isLive(): bool
    {
        return $this->live;
    }

    public function getCarriers(): CarrierCollection
    {
        return $this->carriers;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'name'          => $this->name,
            'contactPerson' => $this->contactPerson,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'url'           => $this->url,
            'street'        => $this->street,
            'city'          => $this->city,
            'zip'           => $this->zip,
            'country'       => $this->country,
            'live'          => $this->live,
            'carriers'      => $this->carriers->__toArray(),

        ];
    }
}
