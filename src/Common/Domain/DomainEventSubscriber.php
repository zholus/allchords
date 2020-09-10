<?php
declare(strict_types=1);

namespace App\Common\Domain;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $event): void;
    public function isSubscribedTo(DomainEvent $event): bool;
}
