<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Songs;

use App\Common\Domain\DomainEvent;
use DateTimeImmutable;

class SongCreated implements DomainEvent
{
    private SongId $id;

    public function __construct(SongId $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function eventName(): string
    {
        return self::class;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
