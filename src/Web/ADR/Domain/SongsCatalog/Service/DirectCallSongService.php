<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsCatalog\Service;

use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\GetSongsByCreatedDateQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\SongsDto;
use App\Web\ADR\Domain\SongsCatalog\ViewModel\Song;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallSongService implements SongsService
{
    private MessageBusInterface $bus;
    private ViewModelMapper $viewModelMapper;
    private LoggerInterface $logger;

    public function __construct(
        MessageBusInterface $bus,
        ViewModelMapper $viewModelMapper,
        LoggerInterface $logger
    ) {
        $this->bus = $bus;
        $this->viewModelMapper = $viewModelMapper;
        $this->logger = $logger;
    }

    /**
     * @return Song[]
     */
    public function getSongsByCreatedDate(int $limit, ?DateTimeImmutable $date): array
    {
        try {
            /** @var SongsDto $songsDto */
            $songsDto = $this->bus->dispatch(new GetSongsByCreatedDateQuery(3, $date))
                ->last(HandledStamp::class)
                ->getResult();

            $songs = $songsDto->getSongs();
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception
            ]);

            $songs = [];
        }

        $result = [];

        foreach ($songs as $song) {
            $result[] = $this->viewModelMapper->mapSongsByCreatedDate($song);
        }

        return $result;
    }
}
