<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\CreateNewComment;

use App\Modules\Comments\Domain\Authors\AuthorId;
use App\Modules\Comments\Domain\Authors\AuthorNotFoundException;
use App\Modules\Comments\Domain\Authors\AuthorRepository;
use App\Modules\Comments\Domain\Songs\CommentId;
use App\Modules\Comments\Domain\Songs\CommentRepository;
use App\Modules\Comments\Domain\Songs\SongId;
use App\Modules\Comments\Domain\Songs\SongRepository;
use App\Modules\Comments\Domain\Songs\SongNotFoundException;

class CreateNewSongCommentHandler
{
    private SongRepository $songs;
    private AuthorRepository $authors;
    private CommentRepository $comments;

    public function __construct(SongRepository $songs, AuthorRepository $authors, CommentRepository $comments)
    {
        $this->songs = $songs;
        $this->authors = $authors;
        $this->comments = $comments;
    }

    public function __invoke(CreateNewSongCommentCommand $command): string
    {
        $authorId = new AuthorId($command->getAuthorId());
        $songId = new SongId($command->getSongId());
        $commentText = $command->getText();

        $song = $this->songs->getById($songId);

        if ($song === null) {
            throw SongNotFoundException::withId($songId);
        }

        $author = $this->authors->getById($authorId);

        if ($author === null) {
            throw AuthorNotFoundException::withId($authorId);
        }

        $song->addComment(
            new CommentId($this->comments->nextIdentity()),
            $author,
            $commentText
        );

        $this->songs->add($song);

        return $song->getComments()->last()->getId()->toString();
    }
}
