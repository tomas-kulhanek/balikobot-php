<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\AdrUnit;

use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultAdrUnit extends BaseModel implements AdrUnit
{
    private string $carrier;
    private string $id;
    private string $code;
    private string $name;
    private string $class;
    private ?string $packaging;
    private ?string $tunnelCode;
    private string $transportCategory;

    public function __construct(string $carrier, string $id, string $code, string $name, string $class, ?string $packaging, ?string $tunnelCode, string $transportCategory)
    {
        $this->carrier           = $carrier;
        $this->id                = $id;
        $this->code              = $code;
        $this->name              = $name;
        $this->class             = $class;
        $this->packaging         = $packaging;
        $this->tunnelCode        = $tunnelCode;
        $this->transportCategory = $transportCategory;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getPackaging(): ?string
    {
        return $this->packaging;
    }

    public function getTunnelCode(): ?string
    {
        return $this->tunnelCode;
    }

    public function getTransportCategory(): string
    {
        return $this->transportCategory;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'class' => $this->class,
            'packaging' => $this->packaging,
            'tunnelCode' => $this->tunnelCode,
            'transportCategory' => $this->transportCategory,
        ];
    }
}
