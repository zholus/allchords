<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\CreateNewSong;

use App\Common\Application\Command\Command;

final class CreateNewSongCommand implements Command
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
