<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserByRefreshToken;

use App\Common\Application\Query\Query;

final class GetUserByRefreshTokenQuery implements Query
{
    private string $refreshToken;

    public function __construct(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
