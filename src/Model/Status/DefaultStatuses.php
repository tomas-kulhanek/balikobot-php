<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Status;

use Inspirum\Arrayable\BaseModel;
use InvalidArgumentException;
use function sprintf;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultStatuses extends BaseModel implements Statuses
{
    private string $carrier;
    private string $carrierId;
    private StatusCollection $states;

    public function __construct(string $carrier, string $carrierId, StatusCollection $states)
    {
        $this->carrier   = $carrier;
        $this->carrierId = $carrierId;
        $this->states    = $states;
        foreach ($states as $status) {
            $this->validateCarrierId($status);
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateCarrierId(Status $item): void
    {
        if ($this->carrierId !== $item->getCarrierId()) {
            throw new InvalidArgumentException(sprintf('Item carrier ID mismatch ("%s" instead "%s")', $item->getCarrierId(), $this->carrierId));
        }
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getCarrierId(): string
    {
        return $this->carrierId;
    }

    public function getStates(): StatusCollection
    {
        return $this->states;
    }

    /**
     * @return array<string,string|array<int,array<string,mixed>>>
     */
    public function __toArray(): array
    {
        return [
            'carrier'   => $this->carrier,
            'carrierId' => $this->carrierId,
            'states'    => $this->states->__toArray(),
        ];
    }
}
