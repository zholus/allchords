<?php
declare(strict_types=1);

namespace App\Common\Domain;

use App\Modules\Accounts\Domain\DomainEvent;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $event): void;
    public function isSubscribedTo(DomainEvent $event): bool;
}
