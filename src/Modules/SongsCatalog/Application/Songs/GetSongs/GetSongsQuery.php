<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSongs;

use App\Common\Application\Query\Query;
use DateTimeImmutable;

final class GetSongsQuery implements Query
{
    private ?DateTimeImmutable $creationDate;
    private int $limit;
    private int $page;
    private int $perPage;

    public function __construct(
        int $limit,
        int $page,
        int $perPage,
        ?DateTimeImmutable $creationDate
    ) {
        $this->limit = $limit;
        $this->creationDate = $creationDate;
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getCreationDate(): ?DateTimeImmutable
    {
        return $this->creationDate;
    }
}
