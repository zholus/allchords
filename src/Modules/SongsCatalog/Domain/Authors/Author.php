<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Authors;

class Author
{
    private AuthorId $id;
    private string $title;

    public function __construct(AuthorId $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
}
