<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use DomainException;

class UserNotFoundException extends DomainException
{
    public static function withEmail(string $email): UserNotFoundException
    {
        return new self(sprintf('User with email [%s] not found', $email));
    }

    public static function withGivenCredentials(): UserNotFoundException
    {
        return new self('User with given email and password not found');
    }
}
