<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Authors;

interface AuthorRepository
{
    public function add(Author $author): void;
    public function getById(AuthorId $id): ?Author;
    public function getByUsername(string $username): ?Author;
}
