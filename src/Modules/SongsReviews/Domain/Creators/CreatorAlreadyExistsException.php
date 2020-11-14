<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Creators;

use DomainException;

final class CreatorAlreadyExistsException extends DomainException
{
    public static function withId(CreatorId $id): self
    {
        return new self(
            sprintf(
                'Creator with [%s] id already exists',
                $id->toString()
            )
        );
    }
}
