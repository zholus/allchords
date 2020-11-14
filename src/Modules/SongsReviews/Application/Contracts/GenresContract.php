<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Contracts;

use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GenresPaginatedCollection;

interface GenresContract
{
    public function getGenresPaginated(?string $genreTitle, int $limit, int $page): GenresPaginatedCollection;
}
