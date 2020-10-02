<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Users;

use App\Common\Domain\DomainEvent;
use App\Modules\Accounts\Domain\DomainEventSubscriber;
use App\Modules\Accounts\Domain\Users\UserCreated;

class SendWelcomeMessage implements DomainEventSubscriber
{
    public function handle(DomainEvent $event): void
    {
        // send to queue...
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return UserCreated::class === $event->eventName();
    }
}
