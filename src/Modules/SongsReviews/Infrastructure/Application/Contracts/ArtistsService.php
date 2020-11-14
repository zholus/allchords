<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Application\Contracts;

use App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated\ArtistsPaginatedCollection;
use App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated\GetArtistsPaginatedQuery;
use App\Modules\SongsReviews\Application\Contracts\ArtistsContract;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class ArtistsService implements ArtistsContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getArtistsPaginated(?string $artistTitle, int $limit, int $page): ArtistsPaginatedCollection
    {
        return $this->bus->dispatch(new GetArtistsPaginatedQuery($artistTitle, $limit, $page))
            ->last(HandledStamp::class)
            ->getResult();
    }
}
