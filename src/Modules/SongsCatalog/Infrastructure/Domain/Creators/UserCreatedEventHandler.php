<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Creators;

use App\Common\Domain\DomainEvent;
use App\Modules\Accounts\Domain\Users\UserCreated;
use App\Modules\SongsCatalog\Application\Creators\CreateNew\CreateNewCreatorCommand;
use App\Modules\SongsCatalog\Domain\DomainEventSubscriber;
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
            $this->bus->dispatch(new CreateNewCreatorCommand(
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
