<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Users;

interface UserRepository
{
    public function add(User $user): void;
    public function getById(UserId $id): ?User;
    public function getByUsername(string $username): ?User;
}
