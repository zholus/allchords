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
    public function getSongsFiltered(int $limit, int $offset, ?DateTimeImmutable $creationDate): array;
    public function getSongsFilteredCount(int $limit, int $offset, ?DateTimeImmutable $getCreationDate): int;
}
