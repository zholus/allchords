<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComments;

class CommentDto
{
    private string $commentId;
    private string $authorId;
    private string $authorUsername;
    private string $text;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $commentId,
        string $authorId,
        string $authorUsername,
        string $text,
        \DateTimeImmutable $createdAt
    ) {
        $this->commentId = $commentId;
        $this->authorId = $authorId;
        $this->authorUsername = $authorUsername;
        $this->text = $text;
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'comment_id' => $this->commentId,
            'author_id' => $this->authorId,
            'author_username' => $this->authorUsername,
            'text' => $this->text,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
