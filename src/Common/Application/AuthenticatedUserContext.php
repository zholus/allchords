<?php
declare(strict_types=1);

namespace App\Common\Application;

interface AuthenticatedUserContext
{
    public function getUserId(): string;
}
