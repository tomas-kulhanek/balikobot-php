<?php

declare(strict_types=1);

namespace Inspirum\Balikobot\Model\Changelog;

use DateTimeInterface;
use Inspirum\Arrayable\BaseModel;

/**
 * @extends \Inspirum\Arrayable\BaseModel<string,mixed>
 */
final class DefaultChangelog extends BaseModel implements Changelog
{
    private string $version;
    private DateTimeInterface $date;
    private ChangelogStatusCollection $changes;

    public function __construct(string $version, DateTimeInterface $date, ChangelogStatusCollection $changes)
    {
        $this->version = $version;
        $this->date    = $date;
        $this->changes = $changes;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function getChanges(): ChangelogStatusCollection
    {
        return $this->changes;
    }

    /** @inheritDoc */
    public function __toArray(): array
    {
        return [
            'code'    => $this->version,
            'date'    => $this->date->format('Y-m-d'),
            'changes' => $this->changes->__toArray(),
        ];
    }
}
