<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

interface SongRepository
{
    public function add(Song $song): void;
    public function getById(SongId $song): ?Song;
}
