<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Authors;

interface AuthorRepository
{
    public function nextIdentity(): AuthorId;
    public function getById(AuthorId $id): ?Author;
    public function add(Author $author): void;
}
