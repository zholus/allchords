<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Creators;

interface CreatorRepository
{
    public function getById(CreatorId $id): ?Creator;
    public function getByUsername(string $username): ?Creator;
    public function add(Creator $creator): void;
}
