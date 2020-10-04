<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComments;

use App\Modules\Comments\Domain\Songs\Comment;
use App\Modules\Comments\Domain\Songs\SongId;
use App\Modules\Comments\Domain\Songs\SongNotFoundException;
use App\Modules\Comments\Domain\Songs\SongRepository;

class GetCommentsHandler
{
    private SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(GetCommentsQuery $command)
    {
        $songId = new SongId($command->getSongId());

        $song = $this->songs->getById($songId);

        if ($song === null) {
            throw SongNotFoundException::withId($songId);
        }

        $page = $command->getPage();
        $limit = $command->getLimit();

        $offset = ($page - 1) * $limit;

        $commentsDto = [];

        foreach ($song->getComments()->slice($offset, $command->getLimit()) as $comment) {
            /** @var Comment $comment */
            $commentsDto[] = new CommentDto(
                $comment->getId()->toString(),
                $comment->getAuthor()->getId()->toString(),
                $comment->getAuthor()->getUsername(),
                $comment->getText(),
                $comment->getCreatedAt()
            );
        }

        return new CommentsDto(
            $songId->toString(),
            $commentsDto
        );
    }
}
