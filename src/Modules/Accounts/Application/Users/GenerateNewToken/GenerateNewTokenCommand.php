<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GenerateNewToken;

class GenerateNewTokenCommand
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
