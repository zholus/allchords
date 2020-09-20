<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Creators;

use DomainException;

final class CreatorNotFoundException extends DomainException
{
    public static function withId(CreatorId $id): self
    {
        return new self(sprintf(
            'Creator with id [%s] not found',
            $id->toString()
        ));
    }
}
