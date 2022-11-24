<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\TransportCost;

use Inspirum\Arrayable\BaseModel;
use function array_map;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultTransportCost extends BaseModel implements TransportCost
{
    private string $batchId;
    private string $carrier;
    private float $totalCost;
    private string $currencyCode;
    /**
     * @var array<\Inspirum\Balikobot\Model\TransportCost\TransportCostPart>
     */
    private array $costsBreakdown = [];

    /**
     * @param array<\Inspirum\Balikobot\Model\TransportCost\TransportCostPart> $costsBreakdown
     */
    public function __construct(string $batchId, string $carrier, float $totalCost, string $currencyCode, array $costsBreakdown = [])
    {
        $this->batchId        = $batchId;
        $this->carrier        = $carrier;
        $this->totalCost      = $totalCost;
        $this->currencyCode   = $currencyCode;
        $this->costsBreakdown = $costsBreakdown;
    }

    public function getBatchId(): string
    {
        return $this->batchId;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /** @inheritDoc */
    public function getCostsBreakdown(): array
    {
        return $this->costsBreakdown;
    }

    /**
     * @return array<string,mixed>
     */
    public function __toArray(): array
    {
        return [
            'batchId'        => $this->batchId,
            'carrier'        => $this->carrier,
            'totalCost'      => $this->totalCost,
            'currencyCode'   => $this->currencyCode,
            'costsBreakdown' => array_map(static fn(TransportCostPart $costPart): array => $costPart->__toArray(), $this->costsBreakdown),
        ];
    }
}
