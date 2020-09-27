<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Creators;

interface CreatorRepository
{
    public function getById(CreatorId $id): ?Creator;
}
