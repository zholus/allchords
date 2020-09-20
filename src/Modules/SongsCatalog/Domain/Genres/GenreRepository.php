<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Genres;

interface GenreRepository
{
    public function nextIdentity(): GenreId;
    public function getById(GenreId $id): ?Genre;
    public function add(Genre $genre): void;
}
