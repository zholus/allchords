<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Accounts\Service;

interface UsersService
{
    public function registerUser(string $username, string $email, string $password): void;
    public function signInUser(string $email, string $password): void;
    public function generateNewToken(string $refreshToken): void;
    public function getTokenByEmail(string $email): string;
    public function signInUserByToken(string $token): void;
}
