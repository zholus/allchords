<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSongs;

class SongDto
{
    private string $songId;
    private string $artistId;
    private string $artistName;
    private string $title;

    public function __construct(
        string $songId,
        string $artistId,
        string $artistName,
        string $title
    ) {
        $this->songId = $songId;
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->title = $title;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }

    public function getArtistId(): string
    {
        return $this->artistId;
    }

    public function getArtistName(): string
    {
        return $this->artistName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
