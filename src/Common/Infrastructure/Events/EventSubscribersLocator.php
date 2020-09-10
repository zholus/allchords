<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Events;

use App\Common\Domain\DomainEventSubscriber;

class EventSubscribersLocator
{
    private array $subscribers = [];

    public function add(DomainEventSubscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    /**
     * @return DomainEventSubscriber[]
     */
    public function getAll(): array
    {
        return $this->subscribers;
    }
}
