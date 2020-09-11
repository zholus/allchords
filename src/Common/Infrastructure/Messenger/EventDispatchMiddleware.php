<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use App\Common\Domain\EventDispatcher;
use App\Common\Infrastructure\Events\EventSubscribersLocator;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class EventDispatchMiddleware implements MiddlewareInterface
{
    private EventSubscribersLocator $eventSubscribersLocator;

    public function __construct(EventSubscribersLocator $eventSubscribersLocator)
    {
        $this->eventSubscribersLocator = $eventSubscribersLocator;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        foreach (EventDispatcher::instance()->getAllEvents() as $event) {
            foreach ($this->eventSubscribersLocator->getAll() as $subscriber) {
                if ($subscriber->isSubscribedTo($event)) {
                    $subscriber->handle($event);
                }
            }
        }

        return $envelope;
    }
}
