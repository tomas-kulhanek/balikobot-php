<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Service;

use Inspirum\Arrayable\BaseCollection;
use function array_map;

/**
 * @extends \Inspirum\Arrayable\BaseCollection<string,mixed,int,\Inspirum\Balikobot\Model\Service\Service>
 */
final class DefaultServiceCollection extends BaseCollection implements ServiceCollection
{
    private string $carrier;
    private ?bool $parcel = null;
    private ?bool $cargo  = null;

    /**
     * @param array<int,\Inspirum\Balikobot\Model\Service\Service> $items
     */
    public function __construct(
        string $carrier,
        array $items = [],
        ?bool $parcel = null,
        ?bool $cargo = null,
    ) {
        $this->cargo   = $cargo;
        $this->parcel  = $parcel;
        $this->carrier = $carrier;
        parent::__construct($items);
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /** @inheritDoc */
    public function getServices(): array
    {
        return $this->getItems();
    }

    /**
     * @return array<string>
     */
    public function getServiceCodes(): array
    {
        return array_map(static fn(Service $service): string => $service->getType(), $this->getServices());
    }

    public function supportsParcel(): ?bool
    {
        return $this->parcel;
    }

    public function supportsCargo(): ?bool
    {
        return $this->cargo;
    }
}
