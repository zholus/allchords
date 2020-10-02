<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Artists;

use App\Modules\SongsCatalog\Domain\Artists\Artist;
use App\Modules\SongsCatalog\Domain\Artists\ArtistId;
use App\Modules\SongsCatalog\Domain\Artists\ArtistRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

class DoctrineArtistRepository extends ServiceEntityRepository implements ArtistRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function nextIdentity(): ArtistId
    {
        return new ArtistId(Uuid::uuid4()->toString());
    }

    public function getById(ArtistId $id): ?Artist
    {
        return $this->find($id);
    }

    public function add(Artist $artist): void
    {
        $this->getEntityManager()->persist($artist);
    }
}
