<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsReviews\Service;

interface ReviewService
{
    public function getArtistsPaginated(?string $artistTitle, int $limit, int $page): array;
    public function getGenresPaginated(?string $genreTitle, int $limit, int $page): array;
}
