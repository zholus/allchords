<?php
declare(strict_types=1);

namespace App\Common\Domain;

abstract class Id
{
    protected string $id;

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

    public function equals(Id $id): bool
    {
        return $this->toString() === $id->toString();
    }
}
