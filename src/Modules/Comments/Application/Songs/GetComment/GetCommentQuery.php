<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComment;

class GetCommentQuery
{
    private string $commentId;

    public function __construct(string $commentId)
    {
        $this->commentId = $commentId;
    }

    public function getCommentId(): string
    {
        return $this->commentId;
    }
}
