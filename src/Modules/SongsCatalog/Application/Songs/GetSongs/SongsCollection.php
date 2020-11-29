<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSongs;

use App\Modules\SongsCatalog\Application\PaginationDto;

class SongsCollection
{
    private array $songs;
    private PaginationDto $paginationDto;

    public function __construct(PaginationDto $paginationDto, SongDto ...$songs)
    {
        $this->songs = $songs;
        $this->paginationDto = $paginationDto;
    }

    public function getSongs(): array
    {
        return $this->songs;
    }

    public function getPaginationDto(): PaginationDto
    {
        return $this->paginationDto;
    }
}
