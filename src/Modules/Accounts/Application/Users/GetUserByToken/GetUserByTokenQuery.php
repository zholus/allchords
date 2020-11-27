<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserByToken;

use App\Common\Application\Query\Query;

final class GetUserByTokenQuery implements Query
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
