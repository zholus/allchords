<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

use App\Modules\Comments\Domain\Authors\Author;
use Doctrine\Common\Collections\Collection;

class Song
{
    private SongId $id;

    /** @var Comment[]|Collection */
    private Collection $comments;

    public function __construct(SongId $id, Collection $comments)
    {
        $this->id = $id;
        $this->comments = $comments;
    }

    public function addComment(CommentId $commentId, Author $author, string $commentText): void
    {
        $this->comments->add(new Comment(
            $commentId,
            $this,
            $author,
            $commentText,
            new \DateTimeImmutable()
        ));
    }

    public function getId(): SongId
    {
        return $this->id;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }
}
