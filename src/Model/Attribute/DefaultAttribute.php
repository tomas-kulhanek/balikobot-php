<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Attribute;

use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultAttribute extends BaseModel implements Attribute
{
    private string $name;
    private string $dataType;
    private ?string $maxLength;

    public function __construct(string $name, string $dataType, ?string $maxLength)
    {
        $this->name      = $name;
        $this->dataType  = $dataType;
        $this->maxLength = $maxLength;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }

    public function getMaxLength(): ?string
    {
        return $this->maxLength;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'name' => $this->name,
            'dataType' => $this->dataType,
            'maxLength' => $this->maxLength,
        ];
    }
}
