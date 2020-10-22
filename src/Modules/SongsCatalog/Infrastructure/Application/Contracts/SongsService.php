<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Application\Contracts;

use App\Modules\SongsCatalog\Application\Contracts\SongsContract;
use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\GetSongsByCreatedDateQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\SongsDto;
use DateTimeImmutable;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SongsService implements SongsContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getSongsByCreatedDate(int $limit, ?DateTimeImmutable $createdAtDate): SongsDto
    {
        return $this->bus->dispatch(new GetSongsByCreatedDateQuery($limit, $createdAtDate))
            ->last(HandledStamp::class)
            ->getResult();
    }
}
