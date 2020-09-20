<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Songs;

class Lyrics
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }
}
