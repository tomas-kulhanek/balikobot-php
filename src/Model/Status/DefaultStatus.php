<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Status;

use DateTimeInterface;
use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultStatus extends BaseModel implements Status
{
    private string $carrier;
    private string $carrierId;
    private float $id;
    private string $name;
    private string $description;
    private string $type;
    private ?DateTimeInterface $date;

    public function __construct(
        string $carrier,
        string $carrierId,
        float $id,
        string $name,
        string $description,
        string $type,
        ?DateTimeInterface $date,
    ) {
        $this->date        = $date;
        $this->type        = $type;
        $this->description = $description;
        $this->name        = $name;
        $this->id          = $id;
        $this->carrierId   = $carrierId;
        $this->carrier     = $carrier;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getCarrierId(): string
    {
        return $this->carrierId;
    }

    public function getId(): float
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'carrier'     => $this->carrier,
            'carrierId'   => $this->carrierId,
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'type'        => $this->type,
            'date' => $this->date instanceof DateTimeInterface ? $this->date->format(DateTimeInterface::ATOM) : null,
        ];
    }
}
