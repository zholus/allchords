<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Authors;

class AuthorAlreadyExistsException extends \DomainException
{
    public static function withId(AuthorId $id): self
    {
        return new self(
            sprintf(
                'Author with [%s] id already exists',
                $id->toString()
            )
        );
    }

    public static function withUsername(string $username): self
    {
        return new self(
            sprintf(
                'Author with [%s] username already exists',
                $username
            )
        );
    }
}
