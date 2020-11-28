<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserId;

use App\Common\Application\Query\Query;

final class GetUserIdQuery implements Query
{
    private string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
