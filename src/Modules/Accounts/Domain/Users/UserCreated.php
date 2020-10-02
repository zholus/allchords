<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use App\Common\Domain\DomainEvent;
use DateTimeImmutable;

final class UserCreated implements DomainEvent
{
    private UserId $userId;
    private string $email;
    private string $username;

    public function __construct(UserId $userId, string $username, string $email)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->username = $username;
    }

    public function getUserId(): string
    {
        return $this->userId->toString();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
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
