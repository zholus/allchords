<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetNewSongsToday;

class SongsDto
{
    private array $songs;

    /**
     * @param SongDto[] $songs
     */
    public function __construct(array $songs)
    {
        $this->songs = $songs;
    }

    public function getSongs(): array
    {
        return $this->songs;
    }
}
