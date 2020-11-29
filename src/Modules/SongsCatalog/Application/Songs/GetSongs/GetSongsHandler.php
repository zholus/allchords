<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSongs;

use App\Common\Application\Query\QueryHandler;
use App\Modules\SongsCatalog\Application\PaginationDto;
use App\Modules\SongsCatalog\Domain\Songs\SongRepository;

final class GetSongsHandler implements QueryHandler
{
    private SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(GetSongsQuery $query): SongsCollection
    {
        $page = $query->getPage();
        $limit = $query->getLimit();
        $offset = ($page - 1) * $limit;

        $allSongsCount = $this->songs->getSongsFilteredCount(
            $limit,
            $offset,
            $query->getCreationDate()
        );

        $songs = $this->songs->getSongsFiltered(
            $limit,
            $offset,
            $query->getCreationDate()
        );

        $pagesCount = (int)ceil(count($songs) / $limit);

        $result = [];

        foreach ($songs as $song) {
            $result[] = new SongDto(
                $song->getId()->toString(),
                $song->getArtist()->getId()->toString(),
                $song->getArtist()->getTitle(),
                $song->getTitle(),
                $song->getCreatedAt()
            );
        }

        $pagination = new PaginationDto(
            $allSongsCount,
            $page,
            $pagesCount,
            $limit
        );

        return new SongsCollection($pagination, ...$result);
    }
}
