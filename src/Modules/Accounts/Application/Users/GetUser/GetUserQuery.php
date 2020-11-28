<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUser;

use App\Common\Application\Query\Query;

final class GetUserQuery implements Query
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
