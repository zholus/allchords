<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Users;

use App\Modules\Accounts\Domain\Users\AccessTokenGenerator;
use Ramsey\Uuid\Uuid;

final class UuidAccessTokenGenerator implements AccessTokenGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
