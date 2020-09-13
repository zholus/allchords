<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use DomainException;

final class UserNotFoundException extends DomainException
{
    public static function withGivenCredentials(): UserNotFoundException
    {
        return new self('User with given email and password not found');
    }
}
