<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Songs;

use DateTimeImmutable;

interface SongRepository
{
    public function nextIdentity(): SongId;
    public function add(Song $song): void;
    public function getById(SongId $id): ?Song;
    /**
     * @return Song[]
     */
    public function getSongsCreatedAtSpecificDate(int $limit, DateTimeImmutable $createdAtDate): array;
}
