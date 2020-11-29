<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSongs;

use DateTimeImmutable;

class SongDto
{
    private string $songId;
    private string $artistId;
    private string $artistName;
    private string $title;
    private DateTimeImmutable $createdAt;

    public function __construct(
        string $songId,
        string $artistId,
        string $artistName,
        string $title,
        DateTimeImmutable $createdAt
    ) {
        $this->songId = $songId;
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->title = $title;
        $this->createdAt = $createdAt;
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
