<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

interface UserRepository
{
    public function nextIdentity(): UserId;
    public function add(User $user): void;
    public function existsWithUsername(string $username): bool;
    public function existsWithEmail(string $email): bool;
    public function getByEmail(string $email): ?User;
    public function getById(UserId $id): ?User;
    public function getByToken(string $token): ?User;
}
