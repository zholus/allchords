<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUser;

class GetUserQuery
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
