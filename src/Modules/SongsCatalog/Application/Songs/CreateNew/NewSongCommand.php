<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\CreateNew;

class NewSongCommand
{
    private string $authorId;
    private string $creatorId;
    private string $genreId;
    private string $title;
    private string $chords;

    public function __construct(
        string $authorId,
        string $creatorId,
        string $genreId,
        string $title,
        string $chords
    ) {
        $this->authorId = $authorId;
        $this->creatorId = $creatorId;
        $this->genreId = $genreId;
        $this->title = $title;
        $this->chords = $chords;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
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
}
