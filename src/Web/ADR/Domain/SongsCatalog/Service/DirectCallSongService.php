<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsCatalog\Service;

use App\Modules\SongsCatalog\Application\Contracts\SongsContract;
use App\Web\ADR\Domain\SongsCatalog\ViewModel\Song;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;

final class DirectCallSongService implements SongsService
{
    private ViewModelMapper $viewModelMapper;
    private LoggerInterface $logger;
    private SongsContract $songContract;

    public function __construct(
        SongsContract $songContract,
        ViewModelMapper $viewModelMapper,
        LoggerInterface $logger
    ) {
        $this->viewModelMapper = $viewModelMapper;
        $this->logger = $logger;
        $this->songContract = $songContract;
    }

    /**
     * @return Song[]
     */
    public function getSongsByCreatedDate(int $limit, ?DateTimeImmutable $date): array
    {
        try {
            $songsDto = $this->songContract->getSongsByCreatedDate($limit, $date);

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
