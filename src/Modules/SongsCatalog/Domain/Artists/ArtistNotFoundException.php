<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Artists;

use DomainException;

final class ArtistNotFoundException extends DomainException
{
    public static function withId(ArtistId $id): self
    {
        return new self(sprintf(
            'Artist with id [%s] not found',
            $id->toString()
        ));
    }
}
