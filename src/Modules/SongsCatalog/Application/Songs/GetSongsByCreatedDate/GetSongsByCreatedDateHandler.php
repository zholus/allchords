<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate;

use App\Modules\SongsCatalog\Domain\Songs\SongRepository;

class GetSongsByCreatedDateHandler
{
    private SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(GetSongsByCreatedDateQuery $query): SongsDto
    {
        $songs = $this->songs->getSongsCreatedAtSpecificDate(
            $query->getLimit(),
            $query->getCreatedAtDate()
        );

        $result = [];

        foreach ($songs as $song) {
            $result[] = new SongDto(
                $song->getId()->toString(),
                $song->getArtist()->getId()->toString(),
                $song->getArtist()->getTitle(),
                $song->getCreator()->getId()->toString(),
                $song->getGenre()->getId()->toString(),
                $song->getTitle(),
                $song->getChords(),
                $song->getCreatedAt()
            );
        }

        return new SongsDto($result);
    }
}
