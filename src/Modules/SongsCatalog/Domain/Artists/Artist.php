<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Artists;

class Artist
{
    private ArtistId $id;
    private string $title;

    public function __construct(ArtistId $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId(): ArtistId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
