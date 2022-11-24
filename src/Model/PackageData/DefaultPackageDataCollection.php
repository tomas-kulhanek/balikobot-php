<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\PackageData;

use Inspirum\Arrayable\BaseCollection;
use function sprintf;
use function substr;
use function time;
use function uniqid;

/**
 * @extends \Inspirum\Arrayable\BaseCollection<string,mixed,int,\Inspirum\Balikobot\Model\PackageData\PackageData>
 */
final class DefaultPackageDataCollection extends BaseCollection implements PackageDataCollection
{
    private string $carrier;

    /**
     * @param array<\Inspirum\Balikobot\Model\PackageData\PackageData> $items
     */
    public function __construct(string $carrier, array $items = [])
    {
        $this->carrier = $carrier;
        parent::__construct([]);
        foreach ($items as $package) {
            $this->add($package);
        }
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /** @inheritDoc */
    public function getPackages(): array
    {
        return $this->getItems();
    }

    public function add(PackageData $item): void
    {
        $this->offsetAdd($item);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @inheritDoc
     */
    public function offsetSet($key, $value): void
    {
        parent::offsetSet($key, $this->clonePackageWithEid($value));
    }

    /**
     * @param mixed $value
     *
     * @inheritDoc
     */
    public function offsetAdd($value): void
    {
        parent::offsetAdd($this->clonePackageWithEid($value));
    }

    private function clonePackageWithEid(PackageData $package): PackageData
    {
        $package = clone $package;

        if ($package->hasEID() === false) {
            $package->setEID($this->newEID());
        }

        return $package;
    }

    private function newEID(): string
    {
        return substr(sprintf('%s%s', time(), uniqid()), -20, 20);
    }
}
