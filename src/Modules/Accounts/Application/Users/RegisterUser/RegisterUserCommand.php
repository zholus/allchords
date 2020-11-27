<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\RegisterUser;

use App\Common\Application\Command\Command;

final class RegisterUserCommand implements Command
{
    private string $username;
    private string $email;
    private string $password;

    public function __construct(
        string $username,
        string $email,
        string $password
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
