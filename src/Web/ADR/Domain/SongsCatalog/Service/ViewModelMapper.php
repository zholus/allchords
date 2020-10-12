<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsCatalog\Service;

use App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate\SongDto;
use App\Web\ADR\Domain\SongsCatalog\ViewModel\Song;

class ViewModelMapper
{
    public function mapSongsByCreatedDate(SongDto $songDto): Song
    {
        return new Song(
            $songDto->getSongId(),
            $songDto->getArtistId(),
            $songDto->getArtistName(),
            $songDto->getTitle(),
            $songDto->getCreatedAt()
        );
    }
}
