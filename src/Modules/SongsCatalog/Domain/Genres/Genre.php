<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Genres;

class Genre
{
    private GenreId $id;
    private string $title;

    public function __construct(GenreId $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId(): GenreId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
