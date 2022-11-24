<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Carrier;

use Inspirum\Arrayable\BaseModel;
use Inspirum\Balikobot\Model\Method\MethodCollection;
use function array_map;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultCarrier extends BaseModel implements Carrier
{
    private string $code;
    private string $name;
    /**
     * @var array<string, \Inspirum\Balikobot\Model\Method\MethodCollection>
     */
    private array $methods = [];

    /**
     * @param array<string,\Inspirum\Balikobot\Model\Method\MethodCollection> $methods
     */
    public function __construct(string $code, string $name, array $methods = [])
    {
        $this->code    = $code;
        $this->name    = $name;
        $this->methods = $methods;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @inheritDoc */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getMethodsForVersion(string $version): MethodCollection
    {
        return $this->methods[$version];
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'code'    => $this->code,
            'name'    => $this->name,
            'methods' => array_map(static fn(MethodCollection $methods) => $methods->__toArray(), $this->methods),
        ];
    }
}
