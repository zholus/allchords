<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Genres;

interface GenreRepository
{
    public function getById(GenreId $id): ?Genre;
    public function getGenresCount(): int;

    /**
     * @return Genre[]
     */
    public function getPaginated(?string $genreTitle, int $limit, int $offset): array;

    /**
     * @param GenreId[] $ids
     * @return Genre[]
     */
    public function getManyById(array $ids): array;
}
