<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

use App\Modules\Comments\Domain\Authors\Author;
use DateTimeImmutable;

class Comment
{
    private CommentId $id;
    private Song $song;
    private Author $author;
    private string $text;
    private DateTimeImmutable $createdAt;

    public function __construct(CommentId $id, Song $song, Author $author, string $text, DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->song = $song;
        $this->author = $author;
        $this->text = $text;
        $this->createdAt = $createdAt;
    }
}
