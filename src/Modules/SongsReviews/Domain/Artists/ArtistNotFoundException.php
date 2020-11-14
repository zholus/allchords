<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Artists;

use DomainException;

final class ArtistNotFoundException extends DomainException
{
    public static function withId(ArtistId $id): self
    {
        return new self(
            sprintf(
                'Artist with id [%s] not found',
                $id
            )
        );
    }

    public static function withIds(array $artistsIds): self
    {
        return new self(
            sprintf(
                'Artists with ids [%s] not found',
                implode(
                    ', ',
                    array_map(
                        fn(ArtistId $artistId) => $artistId->toString(),
                        $artistsIds
                    )
                )
            )
        );
    }
}
