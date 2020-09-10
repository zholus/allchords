<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

use App\Common\Domain\EventDispatcher;

class User
{
    private UserId $id;
    private string $username;
    private string $email;
    private string $password;

    public function __construct(UserId $id, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public static function register(UserId $id, string $username, string $email, string $password): User
    {
        $user = new User (
            $id,
            $username,
            $email,
            $password
        );

        EventDispatcher::instance()->publish(new UserCreated(
            $id,
            $email
        ));

        return $user;
    }

    public function getId(): UserId
    {
        return $this->id;
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
