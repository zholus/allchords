<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GenerateNewToken;

use App\Common\Application\Command\Command;

final class GenerateNewTokenCommand implements Command
{
    private string $refreshToken;

    public function __construct(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
