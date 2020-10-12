<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsCatalog\ViewModel;

use DateTimeImmutable;

class Song
{
    private string $songId;
    private string $artistId;
    private string $artistName;
    private string $songTitle;
    private DateTimeImmutable $createdAt;

    public function __construct(
        string $songId,
        string $artistId,
        string $artistName,
        string $songTitle,
        DateTimeImmutable $createdAt
    ) {
        $this->songId = $songId;
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->songTitle = $songTitle;
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

    public function getSongTitle(): string
    {
        return $this->songTitle;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
