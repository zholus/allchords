<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComment;

class CommentDto
{
    private string $commentId;
    private string $songId;
    private string $authorId;
    private string $authorUsername;
    private string $text;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $commentId,
        string $songId,
        string $authorId,
        string $authorUsername,
        string $text,
        \DateTimeImmutable $createdAt
    ) {
        $this->commentId = $commentId;
        $this->songId = $songId;
        $this->authorId = $authorId;
        $this->authorUsername = $authorUsername;
        $this->text = $text;
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'comment_id' => $this->commentId,
            'song_id' => $this->songId,
            'author_id' => $this->authorId,
            'author_username' => $this->authorUsername,
            'text' => $this->text,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
