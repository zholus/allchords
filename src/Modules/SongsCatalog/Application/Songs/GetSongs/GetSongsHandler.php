<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetNewSongsToday;

use App\Common\Application\Query\QueryHandler;
use App\Modules\SongsCatalog\Domain\Songs\SongRepository;

final class GetNewSongsTodayHandler implements QueryHandler
{
    private SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(GetNewSongsTodayQuery $query): SongsDto
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
                $song->getTitle()
            );
        }

        return new SongsDto($result);
    }
}
