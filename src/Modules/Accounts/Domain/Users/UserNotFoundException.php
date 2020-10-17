<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use DomainException;

final class UserNotFoundException extends DomainException
{
    public static function withGivenCredentials(): self
    {
        return new self('User with given email and password not found');
    }

    public static function withId(UserId $id): self
    {
        return new self(
            sprintf(
                'User with id [%s] not found',
                $id
            )
        );
    }

    public static function withToken(string $token): self
    {
        return new self(
            sprintf(
                'User with token [%s] not found',
                $token
            )
        );
    }
}
