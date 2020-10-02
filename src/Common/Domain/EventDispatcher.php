<?php
declare(strict_types=1);

namespace App\Common\Domain;

class EventDispatcher
{
    /**
     * @var DomainEvent[]
     */
    private array $events = [];

    private static ?EventDispatcher $instance = null;

    public static function instance(): EventDispatcher
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function clear(): void
    {
        $this->events = [];
    }

    public function publish(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return DomainEvent[]
     */
    public function getAllEvents(): array
    {
        return $this->events;
    }
}
