<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

use App\Modules\Comments\Domain\Authors\AuthorId;
use DomainException;

class CommentNotFoundException extends DomainException
{
    public static function withId(CommentId $id): self
    {
        return new self(
            sprintf(
                'Comment with id [%s] not found',
                $id->toString()
            )
        );
    }

    public static function withAuthorId(AuthorId $id): self
    {
        return new self(
            sprintf(
                'Comment with author [%s] not found',
                $id->toString()
            )
        );
    }
}
