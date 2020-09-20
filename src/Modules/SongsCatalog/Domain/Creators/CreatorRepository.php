<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Domain\Creators;

interface CreatorRepository
{
    public function isCreatorExists(CreatorId $id): bool;
}
