<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Users;

use App\Common\Domain\AbstractDomainEventSubscriber;
use App\Modules\Accounts\Domain\DomainEvent;
use App\Modules\Accounts\Domain\Users\UserCreated;

class SendWelcomeMessage extends AbstractDomainEventSubscriber
{
    public function handle(DomainEvent $event): void
    {
        // send to queue...
    }

    protected function getSubscribedEvents(): array
    {
        return [
            UserCreated::class
        ];
    }
}
