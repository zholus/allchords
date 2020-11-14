<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Domain\Creators;

use App\Common\Domain\DomainEvent;
use App\Modules\Accounts\Domain\Users\UserCreated;
use App\Modules\SongsReviews\Application\Creators\NewCreator\NewCreatorCommand;
use App\Modules\SongsReviews\Domain\DomainEventSubscriber;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UserCreatedEventHandler implements DomainEventSubscriber
{
    private MessageBusInterface $bus;
    private LoggerInterface $logger;

    public function __construct(MessageBusInterface $bus, LoggerInterface $logger)
    {
        $this->bus = $bus;
        $this->logger = $logger;
    }

    /**
     * @param UserCreated|DomainEvent $event
     */
    public function handle(DomainEvent $event): void
    {
        try {
            $this->bus->dispatch(new NewCreatorCommand(
                $event->getUserId(),
                $event->getUsername()
            ));
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception
            ]);
        }
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return UserCreated::class === $event->eventName();
    }
}
