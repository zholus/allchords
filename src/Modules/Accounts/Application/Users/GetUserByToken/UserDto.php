<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserByToken;

use DateTimeImmutable;

class UserDto
{
    private string $userId;
    private string $username;
    private string $email;
    private string $accessToken;
    private string $refreshToken;
    private DateTimeImmutable $accessTokenExpiryAt;

    public function __construct(
        string $userId,
        string $username,
        string $email,
        string $accessToken,
        string $refreshToken,
        DateTimeImmutable $accessTokenExpiryAt
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->accessTokenExpiryAt = $accessTokenExpiryAt;
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

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getAccessTokenExpiryAt(): DateTimeImmutable
    {
        return $this->accessTokenExpiryAt;
    }
}
