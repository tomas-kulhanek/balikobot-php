<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Branch;

use IteratorIterator;
use Traversable;

/**
 * @extends \IteratorIterator<int,\Inspirum\Balikobot\Model\Branch\Branch,\Traversable<int,\Inspirum\Balikobot\Model\Branch\Branch>>
 */
final class DefaultBranchIterator extends IteratorIterator implements BranchIterator
{
    private ?string $carrier;
    private ?string $service;
    /**
     * @var array<string>
     */
    private ?array $countries;

    /**
     * @param array<string>                                             $countries
     * @param \Traversable<int,\Inspirum\Balikobot\Model\Branch\Branch> $iterator
     */
    public function __construct(?string $carrier, ?string $service, ?array $countries, Traversable $iterator)
    {
        $this->carrier   = $carrier;
        $this->service   = $service;
        $this->countries = $countries;
        parent::__construct($iterator);
    }

    public function getCarrier(): ?string
    {
        return $this->carrier;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    /** @inheritDoc */
    public function getCountries(): ?array
    {
        return $this->countries;
    }
}
