<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Genres;

use DomainException;

final class GenreNotFoundException extends DomainException
{
    public static function withId(GenreId $id): self
    {
        return new self(
            sprintf(
                'Genre with id [%s] not found',
                $id
            )
        );
    }

    public static function withIds(array $genresIds)
    {
        return new self(
            sprintf(
                'Genres with ids [%s] not found',
                implode(
                    ', ',
                    array_map(
                        fn(GenreId $genreId) => $genreId->toString(),
                        $genresIds
                    )
                )
            )
        );
    }
}
