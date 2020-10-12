<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Songs;

use App\Modules\SongsCatalog\Domain\Songs\Song;
use App\Modules\SongsCatalog\Domain\Songs\SongId;
use App\Modules\SongsCatalog\Domain\Songs\SongRepository;
use DateTimeImmutable;
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

    public function getById(SongId $id): ?Song
    {
        return $this->find($id);
    }

    /**
     * @return Song[]
     */
    public function getSongsCreatedAtSpecificDate(int $limit, DateTimeImmutable $createdAtDate): array
    {
        $builder = $this->createQueryBuilder('s');
        $builder->where('s.createdAt >= :date_from',  's.createdAt <= :date_to');
        $builder->setMaxResults($limit);
        $builder->setParameter(':date_from', $createdAtDate->setTime(0, 0));
        $builder->setParameter(':date_to', $createdAtDate->setTime(23, 59, 59, 9999));

        $query = $builder->getQuery();

        return $query->getResult();
    }
}
