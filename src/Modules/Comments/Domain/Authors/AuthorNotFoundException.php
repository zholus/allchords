<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Authors;

class AuthorNotFoundException extends \DomainException
{
    public static function withId(AuthorId $id): self
    {
        return new self(sprintf(
            'Author with id [%s] not found',
            $id->toString()
        ));
    }
}
