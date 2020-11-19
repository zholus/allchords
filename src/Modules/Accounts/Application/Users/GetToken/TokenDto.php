<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetToken;

class TokenDto
{
    private string $token;
    private \DateTimeImmutable $expiryAt;
    private string $refreshToken;

    public function __construct(string $token, string $refreshToken, \DateTimeImmutable $expiryAt)
    {
        $this->token = $token;
        $this->expiryAt = $expiryAt;
        $this->refreshToken = $refreshToken;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getExpiryAt(): \DateTimeImmutable
    {
        return $this->expiryAt;
    }
}
