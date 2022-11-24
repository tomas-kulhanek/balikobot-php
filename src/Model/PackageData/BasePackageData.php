<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\PackageData;

use Inspirum\Arrayable\BaseModel;
use Inspirum\Balikobot\Model\PackageData\Package\CommonData;
use ReturnTypeWillChange;
use function array_key_exists;
use function count;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
abstract class BasePackageData extends BaseModel implements PackageData
{
    use CommonData;

    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /** @inheritDoc */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param mixed $key
     */
    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    #[ReturnTypeWillChange]
    public function offsetGet($key)
    {
        return $this->data[$key];
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function offsetSet($key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key): void
    {
        unset($this->data[$key]);
    }

    public function count(): int
    {
        return count($this->data);
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return $this->data;
    }
}
