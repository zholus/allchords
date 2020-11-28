<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComment;

use App\Common\Application\Query\Query;

final class GetCommentQuery implements Query
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
