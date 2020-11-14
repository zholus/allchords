<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated;

use App\Modules\SongsReviews\Application\PaginationDto;

class ArtistsPaginatedCollection
{
    private array $artistsDto;
    private PaginationDto $paginationDto;

    public function __construct(array $artistsDto, PaginationDto $paginationDto)
    {
        $this->artistsDto = $artistsDto;
        $this->paginationDto = $paginationDto;
    }

    /**
     * @return ArtistDto[]
     */
    public function getArtistsDto(): array
    {
        return $this->artistsDto;
    }

    public function getPaginationDto(): PaginationDto
    {
        return $this->paginationDto;
    }
}
