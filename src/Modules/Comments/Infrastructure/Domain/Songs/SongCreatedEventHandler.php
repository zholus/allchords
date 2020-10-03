<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Domain\Songs;

use App\Common\Domain\DomainEvent;
use App\Modules\Comments\Application\Songs\CreateNew\CreateNewSongCommand;
use App\Modules\Comments\Domain\DomainEventSubscriber;
use App\Modules\SongsCatalog\Domain\Songs\SongCreated;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SongCreatedEventHandler implements DomainEventSubscriber
{
    private MessageBusInterface $bus;
    private LoggerInterface $logger;

    public function __construct(MessageBusInterface $bus, LoggerInterface $logger)
    {
        $this->bus = $bus;
        $this->logger = $logger;
    }

    /**
     * @param SongCreated|DomainEvent $event
     */
    public function handle(DomainEvent $event): void
    {
        try {
            $this->bus->dispatch(new CreateNewSongCommand($event->getId()));
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception
            ]);
        }
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return SongCreated::class === $event->eventName();
    }
}
