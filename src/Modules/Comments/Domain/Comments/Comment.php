<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Comments;

use App\Modules\SongsCatalog\Domain\Users\User;
use DateTimeImmutable;

class Comment
{
    private CommentId $id;
    private User $user;
    private string $text;
    private DateTimeImmutable $createdAt;
    private ?Comment $parentComment;

    public function __construct(CommentId $id, User $user, string $text, ?Comment $parentComment, DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->user = $user;
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->parentComment = $parentComment;
    }

    public static function new(CommentId $id, User $user, string $text, ?Comment $parentComment): self
    {
        $comment = new self(
            $id,
            $user,
            $text,
            $parentComment,
            new DateTimeImmutable()
        );

        // dispatch event

        return $comment;
    }
}
