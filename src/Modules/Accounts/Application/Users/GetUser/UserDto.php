<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUser;

class UserDto
{
    private string $userId;
    private string $username;
    private string $email;

    public function __construct(string $userId, string $username, string $email)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
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
}
