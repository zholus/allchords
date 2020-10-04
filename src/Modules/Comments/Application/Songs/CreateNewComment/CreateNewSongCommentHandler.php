<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\CreateNewComment;

use App\Modules\Comments\Domain\Authors\AuthorId;
use App\Modules\Comments\Domain\Authors\AuthorNotFoundException;
use App\Modules\Comments\Domain\Authors\AuthorRepository;
use App\Modules\Comments\Domain\Songs\SongId;
use App\Modules\Comments\Domain\Songs\SongRepository;
use App\Modules\Comments\Domain\Songs\SongNotFoundException;

class CreateNewSongCommentHandler
{
    private SongRepository $songs;
    private AuthorRepository $authors;

    public function __construct(SongRepository $songs, AuthorRepository $authors)
    {
        $this->songs = $songs;
        $this->authors = $authors;
    }

    public function __invoke(CreateNewSongCommentCommand $command)
    {
        $authorId = new AuthorId($command->getAuthorId());
        $songId = new SongId($command->getSongId());

        if ($this->songs->getById($songId) === null) {
            throw SongNotFoundException::withId($songId);
        }

        if ($this->authors->getById($authorId) === null) {
            throw AuthorNotFoundException::withId($authorId);
        }

        // todo: add song comment
    }
}
