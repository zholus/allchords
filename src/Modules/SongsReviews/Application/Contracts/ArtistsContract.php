<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Contracts;

use App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated\ArtistsPaginatedCollection;

interface ArtistsContract
{
    public function getArtistsPaginated(?string $artistTitle, int $limit, int $page): ArtistsPaginatedCollection;
}
