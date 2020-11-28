<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

use App\Modules\Comments\Domain\Authors\Author;

interface CommentRepository
{
    public function nextIdentity(): string;
    public function getById(CommentId $id): ?Comment;
    public function getLastCommentByAuthor(Author $authorId): ?Comment;
}
