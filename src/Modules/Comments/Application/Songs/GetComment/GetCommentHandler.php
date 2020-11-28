<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComment;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Comments\Domain\Songs\CommentId;
use App\Modules\Comments\Domain\Songs\CommentNotFoundException;
use App\Modules\Comments\Domain\Songs\CommentRepository;

final class GetCommentHandler implements QueryHandler
{
    private CommentRepository $comments;

    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    public function __invoke(GetCommentQuery $command)
    {
        $commentId = new CommentId($command->getCommentId());

        $comment = $this->comments->getById($commentId);

        if ($comment === null) {
            throw CommentNotFoundException::withId($commentId);
        }

        return new CommentDto(
            $comment->getId()->toString(),
            $comment->getSong()->getId()->toString(),
            $comment->getAuthor()->getId()->toString(),
            $comment->getAuthor()->getUsername(),
            $comment->getText(),
            $comment->getCreatedAt()
        );
    }
}
