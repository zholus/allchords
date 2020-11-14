<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated;

use App\Modules\SongsReviews\Application\PaginationDto;
use App\Modules\SongsReviews\Domain\Artists\ArtistRepository;

class GetArtistsPaginatedHandler
{
    private ArtistRepository $artists;

    public function __construct(ArtistRepository $artists)
    {
        $this->artists = $artists;
    }

    public function __invoke(GetArtistsPaginatedQuery $query): ArtistsPaginatedCollection
    {
        $page = $query->getPage();
        $limit = $query->getLimit();
        $offset = ($page - 1) * $limit;

        $artistsCount = $this->artists->getArtistsCount();
        $pagesCount = (int)ceil($artistsCount / $limit);

        $paginated = $this->artists->getPaginated($query->getArtistTitle(), $limit, $offset);
        $artists = [];
        foreach ($paginated as $artist) {
            $artists[] = new ArtistDto($artist->getId()->toString(), $artist->getTitle());
        }

        return new ArtistsPaginatedCollection(
            $artists,
            new PaginationDto(
                $artistsCount,
                $page,
                $pagesCount,
                $limit
            )
        );
    }
}
