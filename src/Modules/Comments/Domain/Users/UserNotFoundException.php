<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Users;

class UserNotFoundException extends \DomainException
{
    public static function withId(UserId $id): self
    {
        return new self(sprintf(
            'User with id [%s] not found',
            $id->toString()
        ));
    }
}
