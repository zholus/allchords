<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsCatalog\Service;

use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\GetSongsByCreatedDateQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\SongsDto;
use App\Web\ADR\Domain\SongsCatalog\ViewModel\Song;
use DateTimeImmutable;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallSongService implements SongsService
{
    private MessageBusInterface $bus;
    private ViewModelMapper $viewModelMapper;

    public function __construct(MessageBusInterface $bus, ViewModelMapper $viewModelMapper)
    {
        $this->bus = $bus;
        $this->viewModelMapper = $viewModelMapper;
    }

    /**
     * @return Song[]
     */
    public function getSongsByCreatedDate(int $limit, ?DateTimeImmutable $date): array
    {
        /** @var SongsDto $songsDto */
        $songsDto = $this->bus->dispatch(new GetSongsByCreatedDateQuery(3, $date))
            ->last(HandledStamp::class)
            ->getResult();

        $result = [];

        foreach ($songsDto->getSongs() as $song) {
            $result[] = $this->viewModelMapper->mapSongsByCreatedDate($song);
        }

        return $result;
    }
}
