<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Users;

class User
{
    private UserId $id;
    private string $username;

    public function __construct(UserId $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}
