<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetLastAuthorCommentComment;

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

    public function getCommentId(): string
    {
        return $this->commentId;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getAuthorUsername(): string
    {
        return $this->authorUsername;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
