<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Creators;

interface CreatorRepository
{
    public function add(Creator $creator): void;
    public function getById(CreatorId $creatorId): ?Creator;
}
