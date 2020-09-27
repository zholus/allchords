<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Creators;

use App\Modules\SongsCatalog\Domain\Creators\Creator;
use App\Modules\SongsCatalog\Domain\Creators\CreatorId;
use App\Modules\SongsCatalog\Domain\Creators\CreatorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCreatorRepository extends ServiceEntityRepository implements CreatorRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creator::class);
    }

    public function getById(CreatorId $id): ?Creator
    {
        return $this->find($id);
    }
}
