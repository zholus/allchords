<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\GetSong;

class SongDto
{
    private string $songId;
    private string $artistId;
    private string $creatorId;
    private string $genreId;
    private string $title;
    private string $chords;

    public function __construct(
        string $songId,
        string $artistId,
        string $creatorId,
        string $genreId,
        string $title,
        string $chords
    ) {
        $this->songId = $songId;
        $this->artistId = $artistId;
        $this->creatorId = $creatorId;
        $this->genreId = $genreId;
        $this->title = $title;
        $this->chords = $chords;
    }

    public function toArray(): array
    {
        return [
            'songId' => $this->songId,
            'artistId' => $this->artistId,
            'creatorId' => $this->creatorId,
            'genreId' => $this->genreId,
            'title' => $this->title,
            'chord' => $this->chords
        ];
    }
}
