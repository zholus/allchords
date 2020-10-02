<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Artists;

interface ArtistRepository
{
    public function nextIdentity(): ArtistId;
    public function getById(ArtistId $id): ?Artist;
    public function add(Artist $artist): void;
}
