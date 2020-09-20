<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSong;

use App\Modules\SongsCatalog\Domain\Songs\SongId;
use App\Modules\SongsCatalog\Domain\Songs\SongNotFoundException;
use App\Modules\SongsCatalog\Domain\Songs\SongRepository;

class GetSongHandler
{
    private SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(GetSongQuery $query): SongDto
    {
        $songId = new SongId($query->getSongId());

        $song = $this->songs->getById($songId);

        if ($song === null) {
            throw SongNotFoundException::withId($songId);
        }

        return new SongDto(
            $song->getId()->toString(),
            $song->getAuthor()->getId()->toString(),
            $song->getCreatorId()->toString(),
            $song->getGenre()->getId()->toString(),
            $song->getTitle(),
            $song->getChords()
        );
    }
}
