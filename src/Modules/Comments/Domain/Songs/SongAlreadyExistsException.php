<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

class SongAlreadyExistsException extends \DomainException
{
    public static function withId(SongId $id): self
    {
        return new self(
            sprintf(
                'Song with id [%s] already exists',
                $id->toString()
            )
        );
    }
}
