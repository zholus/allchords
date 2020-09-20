<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUser;

class UserDto
{
    private string $userId;
    private string $username;
    private string $email;

    public function __construct(
        string $userId,
        string $username,
        string $email
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
}
