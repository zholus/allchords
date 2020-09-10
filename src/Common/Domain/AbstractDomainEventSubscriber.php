<?php
declare(strict_types=1);

namespace App\Common\Domain;

abstract class AbstractDomainEventSubscriber implements DomainEventSubscriber
{
    abstract public function handle(DomainEvent $event): void;

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return in_array(
            $event->eventName(),
            $this->getSubscribedEvents(),
            true
        );
    }

    abstract protected function getSubscribedEvents(): array;
}
