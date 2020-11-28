<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComments;

use App\Common\Application\Query\Query;

final class GetCommentsQuery implements Query
{
    private string $songId;
    private int $page;
    private int $limit;

    public function __construct(string $songId, int $page, int $limit)
    {
        $this->songId = $songId;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
