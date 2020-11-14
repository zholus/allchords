<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsCatalog\Service;

use App\Web\ADR\Domain\SongsCatalog\ViewModel\Song;
use DateTimeImmutable;

interface SongsService
{
    /**
     * @return Song[]
     */
    public function getSongsByCreatedDate(int $limit, ?DateTimeImmutable $date): array;
    public function sendToReview(string $title, array $artistsIds, array $genresIds, string $chords): void;
}
