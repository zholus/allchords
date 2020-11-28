<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetLastAuthorCommentComment;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Comments\Domain\Authors\AuthorId;
use App\Modules\Comments\Domain\Authors\AuthorNotFoundException;
use App\Modules\Comments\Domain\Authors\AuthorRepository;
use App\Modules\Comments\Domain\Songs\CommentNotFoundException;
use App\Modules\Comments\Domain\Songs\CommentRepository;

final class GetLastAuthorCommentCommentHandler implements QueryHandler
{
    private CommentRepository $comments;
    private AuthorRepository $authors;

    public function __construct(CommentRepository $comments, AuthorRepository $authors)
    {
        $this->comments = $comments;
        $this->authors = $authors;
    }

    public function __invoke(GetLastAuthorCommentCommentQuery $query)
    {
        $authorId = new AuthorId($query->getAuthorId());

        $author = $this->authors->getById($authorId);

        if ($author === null) {
            throw AuthorNotFoundException::withId($authorId);
        }

        $comment = $this->comments->getLastCommentByAuthor($author);

        if ($comment === null) {
            throw CommentNotFoundException::withAuthorId($authorId);
        }

        return new CommentDto(
            $comment->getId()->toString(),
            $comment->getAuthor()->getId()->toString(),
            $comment->getAuthor()->getUsername(),
            $comment->getText(),
            $comment->getCreatedAt()
        );
    }
}
