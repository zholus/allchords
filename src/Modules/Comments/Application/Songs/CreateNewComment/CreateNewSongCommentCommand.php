<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\CreateNewComment;

use App\Common\Application\Command\Command;

final class CreateNewSongCommentCommand implements Command
{
    private string $authorId;
    private string $songId;
    private string $text;

    public function __construct(string $authorId, string $songId, string $text)
    {
        $this->authorId = $authorId;
        $this->songId = $songId;
        $this->text = $text;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
