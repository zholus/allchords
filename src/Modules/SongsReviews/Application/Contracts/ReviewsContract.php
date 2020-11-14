<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Contracts;

use App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated\ArtistsPaginatedCollection;
use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GenresPaginatedCollection;

interface ReviewsContract
{
    public function getArtistsPaginated(?string $artistTitle, int $limit, int $page): ArtistsPaginatedCollection;
    public function getGenresPaginated(?string $genreTitle, int $limit, int $page): GenresPaginatedCollection;
    public function newReview(
        string $creatorId,
        array $artistsIds,
        array $genresIds,
        string $title,
        string $chords
    ): void;
}
