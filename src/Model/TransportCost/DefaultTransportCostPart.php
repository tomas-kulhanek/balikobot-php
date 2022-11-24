<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\TransportCost;

use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultTransportCostPart extends BaseModel implements TransportCostPart
{
    private string $name;
    private float $cost;
    private string $currencyCode;

    public function __construct(string $name, float $cost, string $currencyCode)
    {
        $this->name         = $name;
        $this->cost         = $cost;
        $this->currencyCode = $currencyCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'name'         => $this->name,
            'cost'         => $this->cost,
            'currencyCode' => $this->currencyCode,
        ];
    }
}
