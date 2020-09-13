<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

class UserId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function equals(UserId $id): bool
    {
        return $this->toString() === $id->toString();
    }
}
