<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Creators;

use Throwable;

class CreatorAlreadyExistsException extends \DomainException
{
    public static function withId(CreatorId $id): self
    {
        return new self(
            sprintf(
                'User with [%s] id already exists',
                $id->toString()
            )
        );
    }

    public static function withUsername(string $username): self
    {
        return new self(
            sprintf(
                'User with [%s] username already exists',
                $username
            )
        );
    }
}
