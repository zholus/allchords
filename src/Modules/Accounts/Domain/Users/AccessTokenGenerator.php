<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

interface AccessTokenGenerator
{
    public function generate(): string;
}
