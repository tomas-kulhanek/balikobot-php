<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Country;

use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultCountry extends BaseModel implements Country
{
    /**
     * @var array<string, string>
     */
    private array $names;
    private string $code;
    private string $currencyCode;
    /**
     * @var array<string>
     */
    private array $phonePrefixes;
    private string $continent;

    /**
     * @param array<string,string> $names
     * @param array<string>        $phonePrefixes
     */
    public function __construct(array $names, string $code, string $currencyCode, array $phonePrefixes, string $continent)
    {
        $this->names         = $names;
        $this->code          = $code;
        $this->currencyCode  = $currencyCode;
        $this->phonePrefixes = $phonePrefixes;
        $this->continent     = $continent;
    }

    /** @inheritDoc */
    public function getNames(): array
    {
        return $this->names;
    }

    public function getName(string $locale): ?string
    {
        return $this->names[$locale] ?? null;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /** @inheritDoc */
    public function getPhonePrefixes(): array
    {
        return $this->phonePrefixes;
    }

    public function getPhonePrefix(): string
    {
        return $this->phonePrefixes[0];
    }

    public function getContinent(): string
    {
        return $this->continent;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'names'         => $this->names,
            'code'          => $this->code,
            'currencyCode'  => $this->currencyCode,
            'phonePrefixes' => $this->phonePrefixes,
            'continent'     => $this->continent,
        ];
    }
}
