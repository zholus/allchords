<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetToken;

class TokenDto
{
    private string $token;
    private \DateTimeImmutable $expiryAt;

    public function __construct(string $token, \DateTimeImmutable $expiryAt)
    {
        $this->token = $token;
        $this->expiryAt = $expiryAt;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiryAt(): \DateTimeImmutable
    {
        return $this->expiryAt;
    }
}
