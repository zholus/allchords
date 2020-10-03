<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\CreateNew;

use App\Modules\Comments\Domain\Songs\Song;
use App\Modules\Comments\Domain\Songs\SongAlreadyExistsException;
use App\Modules\Comments\Domain\Songs\SongId;
use App\Modules\Comments\Domain\Songs\SongRepository;

class CreateNewSongHandler
{
    private SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(CreateNewSongCommand $command)
    {
        $songId = new SongId($command->getSongId());

        if ($this->songs->getById($songId) !== null) {
            throw SongAlreadyExistsException::withId($songId);
        }

        $this->songs->add(new Song($songId));
    }
}
