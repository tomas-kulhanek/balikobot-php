<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model;

use Inspirum\Arrayable\BaseCollection;
use InvalidArgumentException;
use RuntimeException;
use function array_map;
use function sprintf;

/**
 * @template TItemKey of array-key
 * @template TItemValue
 * @template TKey of array-key
 * @template TValue of \Inspirum\Arrayable\Arrayable<TItemKey,TItemValue>&\Inspirum\Balikobot\Model\WithCarrierId
 * @extends  \Inspirum\Arrayable\BaseCollection<TItemKey,TItemValue,TKey,TValue>
 * @implements \Inspirum\Balikobot\Model\PerCarrierCollection<TValue>
 */
abstract class BasePerCarrierCollection extends BaseCollection implements PerCarrierCollection
{
    private ?string $carrier = null;

    /**
     * @param array<TKey,TValue> $items
     */
    public function __construct(?string $carrier = null, array $items = [])
    {
        $this->carrier = $carrier;
        parent::__construct([]);
        foreach ($items as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    /**
     * @throws \RuntimeException
     */
    public function getCarrier(): string
    {
        if (!isset($this->carrier)) {
            throw new RuntimeException('Collection is empty');
        }

        return $this->carrier;
    }

    /**
     * @param TValue $item
     *
     * @throws \InvalidArgumentException
     */
    public function add(WithCarrierId $item): void
    {
        $this->offsetAdd($item);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value): void
    {
        $this->validateCarrier($value);

        parent::offsetSet($key, $value);
    }

    /**
     * @param mixed $value
     */
    public function offsetAdd($value): void
    {
        $this->validateCarrier($value);

        parent::offsetAdd($value);
    }

    /**
     * @return TValue|null
     */
    public function getForCarrierId(string $carrierId): ?WithCarrierId
    {
        return $this->first(static fn(WithCarrierId $item) => $item->getCarrierId() === $carrierId);
    }

    /**
     * @param callable(TValue): bool $filter
     *
     * @return TValue|null
     */
    protected function first(callable $filter): ?WithCarrierId
    {
        foreach ($this->items as $package) {
            if ($filter($package)) {
                return $package;
            }
        }

        return null;
    }

    /** @inheritDoc */
    public function getCarrierIds(): array
    {
        return array_map(static fn(WithCarrierId $item) => $item->getCarrierId(), $this->items);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateCarrier(WithCarrierId $item): void
    {
        if ($this->carrier === null) {
            $this->carrier = $item->getCarrier();

            return;
        }

        if ($this->carrier !== $item->getCarrier()) {
            throw new InvalidArgumentException(sprintf('Item carrier mismatch ("%s" instead "%s")', $item->getCarrier(), $this->carrier));
        }
    }
}
