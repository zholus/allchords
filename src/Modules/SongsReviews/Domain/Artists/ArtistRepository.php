<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Artists;

interface ArtistRepository
{
    public function getById(ArtistId $id): ?Artist;

    /**
     * @param ArtistId[] $ids
     * @return Artist[]
     */
    public function getManyById(array $ids): array;

    /**
     * @return Artist[]
     */
    public function getPaginated(?string $artistTitle, int $limit, int $offset): array;
    public function getArtistsCount(): int;
}
