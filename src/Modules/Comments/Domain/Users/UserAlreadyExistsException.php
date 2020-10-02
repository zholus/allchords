<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Users;

class UserAlreadyExistsException extends \DomainException
{
    public static function withId(UserId $id): self
    {
        return new self(
            sprintf(
                'User with [%s] id already exists',
                $id->toString()
            )
        );
    }

    public static function withUsername(string $username): self
    {
        return new self(
            sprintf(
                'User with [%s] username already exists',
                $username
            )
        );
    }
}
