<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetToken;

class GetTokenQuery
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
