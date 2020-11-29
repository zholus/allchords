<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Genres\GetGenresPaginated;

use App\Common\Application\Query\QueryHandler;
use App\Modules\SongsReviews\Application\PaginationDto;
use App\Modules\SongsReviews\Domain\Genres\GenreRepository;

final class GetGenresPaginatedHandler implements QueryHandler
{
    private GenreRepository $genres;

    public function __construct(GenreRepository $genres)
    {
        $this->genres = $genres;
    }

    public function __invoke(GetGenresPaginatedQuery $query): GenresPaginatedCollection
    {
        $page = $query->getPage();
        $limit = $query->getLimit();
        $offset = ($page - 1) * $limit;

        $genresCount = $this->genres->getGenresCount();
        $pagesCount = (int)ceil($genresCount / $limit);

        $paginated = $this->genres->getPaginated($query->getGenreTitle(), $limit, $offset);
        $genres = [];
        foreach ($paginated as $genre) {
            $genres[] = new GenreDto($genre->getId()->toString(), $genre->getTitle());
        }

        return new GenresPaginatedCollection(
            $genres,
            new PaginationDto(
                $genresCount,
                $page,
                $pagesCount,
                $limit
            )
        );
    }
}
