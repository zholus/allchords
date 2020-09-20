<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Songs;

interface SongRepository
{
    public function nextIdentity(): SongId;
    public function add(Song $song): void;
}
