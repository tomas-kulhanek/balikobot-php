<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Attribute;

use Inspirum\Arrayable\BaseCollection;

/**
 * @extends \Inspirum\Arrayable\BaseCollection<string,mixed,int,\Inspirum\Balikobot\Model\Attribute\Attribute>
 */
final class DefaultAttributeCollection extends BaseCollection implements AttributeCollection
{
    private string $carrier;

    /**
     * @param array<int,\Inspirum\Balikobot\Model\Attribute\Attribute> $items
     */
    public function __construct(string $carrier, array $items = [])
    {
        $this->carrier = $carrier;
        parent::__construct($items);
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /** @inheritDoc */
    public function getAttributes(): array
    {
        return $this->items;
    }
}
