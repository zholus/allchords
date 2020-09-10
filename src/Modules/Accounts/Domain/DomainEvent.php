<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain;

use DateTimeImmutable;

interface DomainEvent
{
    public function eventName(): string;
    public function occurredOn(): DateTimeImmutable;
}
