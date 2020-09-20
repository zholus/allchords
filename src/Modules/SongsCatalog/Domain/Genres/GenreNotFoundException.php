<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Genres;

use DomainException;

final class GenreNotFoundException extends DomainException
{
    public static function withId(GenreId $id): self
    {
        return new self(sprintf(
            'Genre with id [%s] not found',
            $id->toString()
        ));
    }
}
