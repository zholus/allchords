<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComments;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Comments\Application\PaginationDto;
use App\Modules\Comments\Domain\Songs\Comment;
use App\Modules\Comments\Domain\Songs\SongId;
use App\Modules\Comments\Domain\Songs\SongNotFoundException;
use App\Modules\Comments\Domain\Songs\SongRepository;

final class GetCommentsHandler implements QueryHandler
{
    private SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(GetCommentsQuery $query)
    {
        $songId = new SongId($query->getSongId());

        $song = $this->songs->getById($songId);

        if ($song === null) {
            throw SongNotFoundException::withId($songId);
        }

        $page = $query->getPage();
        $limit = $query->getLimit();
        $offset = ($page - 1) * $limit;

        $pagesCount = (int)ceil($song->getComments()->count() / $limit);
        $commentsDto = [];

        $comments = $song->getComments()->slice($offset, $query->getLimit());
        foreach ($comments as $comment) {
            /** @var Comment $comment */
            $commentsDto[] = new CommentDto(
                $comment->getId()->toString(),
                $comment->getAuthor()->getId()->toString(),
                $comment->getAuthor()->getUsername(),
                $comment->getText(),
                $comment->getCreatedAt()
            );
        }

        return new CommentsCollection(
            $songId->toString(),
            new PaginationDto(
                $song->getComments()->count(),
                $page,
                $pagesCount,
                count($comments)
            ),
            ...$commentsDto
        );
    }
}
