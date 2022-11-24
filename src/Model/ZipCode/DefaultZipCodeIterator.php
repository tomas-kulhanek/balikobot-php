<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\ZipCode;

use IteratorIterator;
use Traversable;

/**
 * @extends \IteratorIterator<int,\Inspirum\Balikobot\Model\ZipCode\ZipCode,\Traversable<int,\Inspirum\Balikobot\Model\ZipCode\ZipCode>>
 */
final class DefaultZipCodeIterator extends IteratorIterator implements ZipCodeIterator
{
    private string $carrier;
    private ?string $service;

    /**
     * @param \Traversable<int,\Inspirum\Balikobot\Model\ZipCode\ZipCode> $iterator
     */
    public function __construct(string $carrier, ?string $service, Traversable $iterator)
    {
        $this->carrier = $carrier;
        $this->service = $service;
        parent::__construct($iterator);
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getService(): ?string
    {
        return $this->service;
    }
}
