<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use DomainException;

class UserAlreadyExistsException extends DomainException
{
    public static function withEmail(string $email): UserAlreadyExistsException
    {
        return new self(sprintf('User with email [%s] already exists', $email));
    }

    public static function withUsername(string $username): UserAlreadyExistsException
    {
        return new self(sprintf('User with username [%s] already exists', $username));
    }
}
