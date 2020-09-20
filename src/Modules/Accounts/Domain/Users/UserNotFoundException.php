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
}
