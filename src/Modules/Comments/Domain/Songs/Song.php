<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

class Song
{
    private SongId $id;

    public function __construct(SongId $id)
    {
        $this->id = $id;
    }
}
