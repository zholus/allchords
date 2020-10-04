<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

use DomainException;

class SongNotFoundException extends DomainException
{
    public static function withId(SongId $id): self
    {
        return new self(sprintf(
            'Song with id [%s] not found',
            $id->toString()
        ));
    }
}
