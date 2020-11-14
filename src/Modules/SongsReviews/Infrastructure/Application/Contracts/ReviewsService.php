<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Application\Contracts;

use App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated\ArtistsPaginatedCollection;
use App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated\GetArtistsPaginatedQuery;
use App\Modules\SongsReviews\Application\Contracts\ReviewsContract;
use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GenresPaginatedCollection;
use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GetGenresPaginatedQuery;
use App\Modules\SongsReviews\Application\Reviews\NewReview\NewReviewCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class ReviewsService implements ReviewsContract
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

    public function getGenresPaginated(?string $genreTitle, int $limit, int $page): GenresPaginatedCollection
    {
        return $this->bus->dispatch(new GetGenresPaginatedQuery($genreTitle, $limit, $page))
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function newReview(
        string $creatorId,
        array $artistsIds,
        array $genresIds,
        string $title,
        string $chords
    ): void {
        $this->bus->dispatch(new NewReviewCommand(
            $artistsIds,
            $creatorId,
            $genresIds,
            $title,
            $chords
        ));
    }
}
