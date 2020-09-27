<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Songs;

use App\Modules\SongsCatalog\Domain\Authors\Author;
use App\Modules\SongsCatalog\Domain\Creators\Creator;
use App\Modules\SongsCatalog\Domain\Genres\Genre;
use DateTimeImmutable;

class Song
{
    private SongId $id;
    private Author $author;
    private Creator $creator;
    private Genre $genre;
    private string $title;
    private string $chords;
    private DateTimeImmutable $createdAt;

    public function __construct(
        SongId $id,
        Author $author,
        Creator $creator,
        Genre $genre,
        string $title,
        string $chords,
        DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->creator = $creator;
        $this->genre = $genre;
        $this->title = $title;
        $this->chords = $chords;
        $this->createdAt = $createdAt;
    }

    public static function new(
        SongId $id,
        Author $author,
        Creator $creator,
        Genre $genre,
        string $title,
        string $chords
    ): Song {
        return new self(
            $id,
            $author,
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

    public function getAuthor(): Author
    {
        return $this->author;
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
