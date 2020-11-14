<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsReviews\Service;

use App\Modules\SongsReviews\Application\Contracts\ArtistsContract;
use App\Modules\SongsReviews\Application\Contracts\GenresContract;
use App\Modules\SongsReviews\Application\Contracts\ReviewsContract;

final class DirectCallReviewService implements ReviewService
{
    private ReviewsContract $reviewsContract;
    private ArtistsContract $artistsContract;
    private GenresContract $genresContract;

    public function __construct(
        ReviewsContract $reviewsContract,
        ArtistsContract $artistsContract,
        GenresContract $genresContract
    ) {
        $this->reviewsContract = $reviewsContract;
        $this->artistsContract = $artistsContract;
        $this->genresContract = $genresContract;
    }

    public function getArtistsPaginated(?string $artistTitle, int $limit, int $page): array
    {
        $paginatedResult = $this->artistsContract->getArtistsPaginated($artistTitle, $limit, $page);

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
        $paginatedResult = $this->genresContract->getGenresPaginated($genreTitle, $limit, $page);

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
