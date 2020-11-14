<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsReviews\Service;

use App\Modules\SongsReviews\Application\Contracts\ReviewsContract;

final class DirectCallReviewService implements ReviewService
{
    private ReviewsContract $reviewsContract;

    public function __construct(ReviewsContract $reviewsContract)
    {
        $this->reviewsContract = $reviewsContract;
    }

    public function getArtistsPaginated(?string $artistTitle, int $limit, int $page): array
    {
        $paginatedResult = $this->reviewsContract->getArtistsPaginated($artistTitle, $limit, $page);

        $artists = [];
        foreach ($paginatedResult->getArtistsDto() as $artist) {
            $artists[] = new ArtistDto($artist->getId(), $artist->getTitle());
        }

        $pagination = new PaginationDto(
            $paginatedResult->getPaginationDto()->getTotalElementsCount(),
            $paginatedResult->getPaginationDto()->getCurrentPage(),
            $paginatedResult->getPaginationDto()->getTotalPagesCount(),
            $paginatedResult->getPaginationDto()->getElementsOnPage()
        );

        return [$artists, $pagination];
    }

    public function getGenresPaginated(?string $genreTitle, int $limit, int $page): array
    {
        $paginatedResult = $this->reviewsContract->getGenresPaginated($genreTitle, $limit, $page);

        $genres = [];
        foreach ($paginatedResult->getGenresDto() as $genre) {
            $genres[] = new GenreDto($genre->getId(), $genre->getTitle());
        }

        $pagination = new PaginationDto(
            $paginatedResult->getPaginationDto()->getTotalElementsCount(),
            $paginatedResult->getPaginationDto()->getCurrentPage(),
            $paginatedResult->getPaginationDto()->getTotalPagesCount(),
            $paginatedResult->getPaginationDto()->getElementsOnPage()
        );

        return [$genres, $pagination];
    }
}
