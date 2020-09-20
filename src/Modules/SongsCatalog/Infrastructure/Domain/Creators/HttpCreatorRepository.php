<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Creators;

use App\Modules\SongsCatalog\Domain\Creators\Creator;
use App\Modules\SongsCatalog\Domain\Creators\CreatorId;
use App\Modules\SongsCatalog\Domain\Creators\CreatorRepository;

class HttpCreatorRepository implements CreatorRepository
{
    public function getById(CreatorId $id): ?Creator
    {
        // todo:
        return null;
    }
}
