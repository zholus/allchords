<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Users\CreateUser;

class CreateUserCommand
{
    private string $userId;
    private string $username;

    public function __construct(string $userId, string $username)
    {
        $this->userId = $userId;
        $this->username = $username;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
