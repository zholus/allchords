<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetNewSongsToday;

use App\Common\Application\Query\Query;
use DateTimeImmutable;

final class GetNewSongsTodayQuery implements Query
{
    private ?DateTimeImmutable $createdAtDate;
    private int $limit;

    public function __construct(int $limit, ?DateTimeImmutable $createdAtDate)
    {
        $this->limit = $limit;
        $this->createdAtDate = $createdAtDate;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getCreatedAtDate(): ?DateTimeImmutable
    {
        return $this->createdAtDate;
    }
}
