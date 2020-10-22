<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Contracts;

use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\SongsDto;
use DateTimeImmutable;

interface SongsContract
{
    public function getSongsByCreatedDate(int $limit, ?DateTimeImmutable $createdAtDate): SongsDto;
}
