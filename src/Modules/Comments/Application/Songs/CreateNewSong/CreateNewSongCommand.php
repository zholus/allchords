<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\CreateNewSong;

class CreateNewSongCommand
{
    private string $songId;

    public function __construct(string $songId)
    {
        $this->songId = $songId;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }
}
