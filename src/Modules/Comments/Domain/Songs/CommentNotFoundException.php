<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

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
}
