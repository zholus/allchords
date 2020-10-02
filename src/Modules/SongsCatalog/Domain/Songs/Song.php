<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Songs;

use App\Modules\SongsCatalog\Domain\Artists\Artist;
use App\Modules\SongsCatalog\Domain\Creators\Creator;
use App\Modules\SongsCatalog\Domain\Genres\Genre;
use DateTimeImmutable;

class Song
{
    private SongId $id;
    private Artist $artist;
    private Creator $creator;
    private Genre $genre;
    private string $title;
    private string $chords;
    private DateTimeImmutable $createdAt;

    public function __construct(
        SongId $id,
        Artist $artist,
        Creator $creator,
        Genre $genre,
        string $title,
        string $chords,
        DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->artist = $artist;
        $this->creator = $creator;
        $this->genre = $genre;
        $this->title = $title;
        $this->chords = $chords;
        $this->createdAt = $createdAt;
    }

    public static function new(
        SongId $id,
        Artist $artist,
        Creator $creator,
        Genre $genre,
        string $title,
        string $chords
    ): Song {
        return new self(
            $id,
            $artist,
            $creator,
            $genre,
            $title,
            $chords,
            new DateTimeImmutable()
        );
    }

    public function getId(): SongId
    {
        return $this->id;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }

    public function getCreator(): Creator
    {
        return $this->creator;
    }

    public function getGenre(): Genre
    {
        return $this->genre;
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
