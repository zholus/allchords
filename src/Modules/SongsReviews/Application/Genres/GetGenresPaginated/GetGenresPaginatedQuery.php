<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Genres\GetGenresPaginated;

use App\Common\Application\Query\Query;

final class GetGenresPaginatedQuery implements Query
{
    private ?string $genreTitle;
    private int $limit;
    private int $page;

    public function __construct(?string $genreTitle, int $limit, int $page)
    {
        $this->genreTitle = $genreTitle;
        $this->limit = $limit;
        $this->page = $page;
    }

    public function getGenreTitle(): ?string
    {
        return $this->genreTitle;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
