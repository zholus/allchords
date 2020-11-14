<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Application\Contracts;

use App\Modules\SongsReviews\Application\Contracts\GenresContract;
use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GenresPaginatedCollection;
use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GetGenresPaginatedQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GenresService implements GenresContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getGenresPaginated(?string $genreTitle, int $limit, int $page): GenresPaginatedCollection
    {
        return $this->bus->dispatch(new GetGenresPaginatedQuery($genreTitle, $limit, $page))
            ->last(HandledStamp::class)
            ->getResult();
    }
}
