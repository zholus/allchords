<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Accounts;

class User
{
    private string $userId;
    private string $username;
    private string $email;
    private string $token;

    public function __construct(string $userId, string $username, string $email, string $token)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->token = $token;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
