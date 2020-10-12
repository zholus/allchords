<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSongsByCreatedDate;

use DateTimeImmutable;

class SongDto
{
    private string $songId;
    private string $artistId;
    private string $artistName;
    private string $creatorId;
    private string $genreId;
    private string $title;
    private string $chords;
    private DateTimeImmutable $createdAt;

    public function __construct(
        string $songId,
        string $artistId,
        string $artistName,
        string $creatorId,
        string $genreId,
        string $title,
        string $chords,
        DateTimeImmutable $createdAt
    ) {
        $this->songId = $songId;
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->creatorId = $creatorId;
        $this->genreId = $genreId;
        $this->title = $title;
        $this->chords = $chords;
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

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function getGenreId(): string
    {
        return $this->genreId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getChords(): string
    {
        return $this->chords;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
