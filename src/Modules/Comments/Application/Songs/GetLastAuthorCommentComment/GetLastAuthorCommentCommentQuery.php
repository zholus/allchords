<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetLastAuthorCommentComment;

use App\Common\Application\Query\Query;

final class GetLastAuthorCommentCommentQuery implements Query
{
    private string $authorId;

    public function __construct(string $authorId)
    {
        $this->authorId = $authorId;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }
}
