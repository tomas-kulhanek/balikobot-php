<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Service;

use Inspirum\Arrayable\BaseModel;
use Inspirum\Balikobot\Model\Country\CodCountry;
use function array_map;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultService extends BaseModel implements Service
{
    private ?ServiceOptionCollection $options = null;
    private ?string $name;
    private string $type;
    /** @var string[]|null */
    private ?array $countries = null;
    /** @var \Inspirum\Balikobot\Model\Country\CodCountry[]|null  */
    private ?array $codCountries = null;

    /**
     * @param array<string>|null                                       $countries
     * @param array<\Inspirum\Balikobot\Model\Country\CodCountry>|null $codCountries
     */
    public function __construct(
        string $type,
        ?string $name,
        ?ServiceOptionCollection $options = null,
        ?array $countries = null,
        ?array $codCountries = null,
    ) {
        $this->codCountries = $codCountries;
        $this->countries    = $countries;
        $this->type         = $type;
        $this->name         = $name;
        $this->options      = $options;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOptions(): ?ServiceOptionCollection
    {
        return $this->options;
    }

    /** @inheritDoc */
    public function getCountries(): ?array
    {
        return $this->countries;
    }

    /** @inheritDoc */
    public function getCodCountries(): ?array
    {
        return $this->codCountries;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'type'         => $this->type,
            'name'         => $this->name,
            'options' => !empty($this->options) ? $this->options->__toArray() : null,
            'countries'    => $this->countries,
            'codCountries' => $this->codCountries !== null ? array_map(static fn(CodCountry $country): array => $country->__toArray(), $this->codCountries)
                : null,
        ];
    }
}
