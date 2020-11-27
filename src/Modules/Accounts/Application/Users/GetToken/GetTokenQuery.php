<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetToken;

use App\Common\Application\Query\Query;

final class GetTokenQuery implements Query
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
