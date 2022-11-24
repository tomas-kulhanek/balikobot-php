<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\OrderedShipment;

use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultOrderedShipment extends BaseModel implements OrderedShipment
{
    private string $orderId;
    private string $carrier;
    /**
     * @var array<string>
     */
    private array $packageIds;
    private string $handoverUrl;
    private string $labelsUrl;
    private ?string $fileUrl = null;

    /**
     * @param array<string> $packageIds
     */
    public function __construct(string $orderId, string $carrier, array $packageIds, string $handoverUrl, string $labelsUrl, ?string $fileUrl = null)
    {
        $this->orderId     = $orderId;
        $this->carrier     = $carrier;
        $this->packageIds  = $packageIds;
        $this->handoverUrl = $handoverUrl;
        $this->labelsUrl   = $labelsUrl;
        $this->fileUrl     = $fileUrl;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /** @inheritDoc */
    public function getPackageIds(): array
    {
        return $this->packageIds;
    }

    public function getHandoverUrl(): string
    {
        return $this->handoverUrl;
    }

    public function getLabelsUrl(): string
    {
        return $this->labelsUrl;
    }

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'carrier' => $this->carrier,
            'orderId' => $this->orderId,
            'packageIds' => $this->packageIds,
            'handoverUrl' => $this->handoverUrl,
            'labelsUrl' => $this->labelsUrl,
            'fileUrl' => $this->fileUrl,
        ];
    }
}
