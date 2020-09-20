<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Songs;

use App\Modules\SongsCatalog\Domain\Songs\Song;
use App\Modules\SongsCatalog\Domain\Songs\SongId;
use App\Modules\SongsCatalog\Domain\Songs\SongRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

class DoctrineSongRepository extends ServiceEntityRepository implements SongRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    public function nextIdentity(): SongId
    {
        return new SongId(Uuid::uuid4()->toString());
    }

    public function add(Song $song): void
    {
        $this->getEntityManager()->persist($song);
    }

    public function getById(SongId $songId): ?Song
    {
        return $this->find($songId);
    }
}
