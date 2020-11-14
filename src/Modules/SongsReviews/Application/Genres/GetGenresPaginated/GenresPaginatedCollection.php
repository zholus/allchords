<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Genres\GetGenresPaginated;

use App\Modules\SongsReviews\Application\PaginationDto;

class GenresPaginatedCollection
{
    private array $genresDto;
    private PaginationDto $paginationDto;

    public function __construct(array $genresDto, PaginationDto $paginationDto)
    {
        $this->genresDto = $genresDto;
        $this->paginationDto = $paginationDto;
    }

    /**
     * @return GenreDto[]
     */
    public function getGenresDto(): array
    {
        return $this->genresDto;
    }

    public function getPaginationDto(): PaginationDto
    {
        return $this->paginationDto;
    }
}
