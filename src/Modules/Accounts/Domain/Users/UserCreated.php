<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use App\Common\Domain\DomainEvent;
use DateTimeImmutable;

final class UserCreated implements DomainEvent
{
    private UserId $userId;
    private string $email;

    public function __construct(UserId $userId, string $email)
    {
        $this->userId = $userId;
        $this->email = $email;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }

    public function eventName(): string
    {
        return self::class;
    }
}
