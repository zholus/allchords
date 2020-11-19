<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Contracts;

use App\Modules\Accounts\Application\Users\GetToken\TokenDto;
use App\Modules\Accounts\Application\Users\GetUserByToken\UserDto;

interface UsersContract
{
    public function registerUser(string $username, string $email, string $password): void;
    public function signInUser(string $email, string $password): void;
    public function getToken(string $email): string;
    public function getUserByToken(string $token): UserDto;
    public function generateNewToken(string $refreshToken): void;
}
