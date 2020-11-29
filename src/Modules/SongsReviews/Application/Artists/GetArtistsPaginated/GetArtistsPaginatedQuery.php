<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Artists\GetArtistsPaginated;

use App\Common\Application\Query\Query;

final class GetArtistsPaginatedQuery implements Query
{
    private ?string $artistTitle;
    private int $limit;
    private int $page;

    public function __construct(?string $artistTitle, int $limit, int $page)
    {
        $this->artistTitle = $artistTitle;
        $this->limit = $limit;
        $this->page = $page;
    }

    public function getArtistTitle(): ?string
    {
        return $this->artistTitle;
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
